<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Tampilkan semua pesanan (Admin: semua | Mitra: hanya miliknya)
     */
    public function index()
    {
        $query = Booking::with(['customer', 'vehicle', 'payment', 'driver', 'vehicleUnit']);

        if (auth('mitra')->check()) {
            $mitraId = auth('mitra')->id();
            $query->whereHas('vehicle', function ($q) use ($mitraId) {
                $q->where('mitra_id', $mitraId);
            });
            $bookings = $query->latest()->get();
            return view('mitra.bookings.index', compact('bookings'));
        }

        $bookings = $query->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update status pesanan + sinkronisasi status unit
     */
    public function update(Request $request, Booking $booking)
    {
        // IDOR Protection untuk Mitra
        if (auth('mitra')->check() && $booking->vehicle->mitra_id !== auth('mitra')->id()) {
            return redirect()->back()->withErrors('Akses Dibatalkan: Anda hanya dapat mengelola pesanan kendaraan Anda sendiri.');
        }

        $request->validate([
            'status'           => 'required|string|in:Pending,Confirmed,Active,Picked_Up,Returning,Completed,Cancelled,Rejected,On_the_Way',
            'payment_status'   => 'nullable|string|in:unpaid,dp_paid,fully_paid,rejected',
            'rejection_reason' => 'required_if:status,Rejected|nullable|string',
        ]);

        $newStatus = $request->status;

        $booking->update([
            'status'           => $newStatus,
            'rejection_reason' => $request->rejection_reason ?? $booking->rejection_reason,
        ]);

        // Update payment status jika dikirim
        if ($request->filled('payment_status')) {
            $booking->payment()->updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'payment_status' => $request->payment_status,
                    'payment_date'   => in_array($request->payment_status, ['dp_paid', 'fully_paid']) ? now() : null,
                ]
            );
        }

        // Sinkronisasi status unit kendaraan
        if (in_array($newStatus, ['Active', 'Picked_Up', 'Returning', 'On_the_Way'])) {
            $booking->vehicleUnit?->update(['status' => 'disewa']);
        } elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
            $booking->vehicle->update(['status' => 'Tersedia']);
            $booking->vehicleUnit?->update(['status' => 'tersedia']);

            // Bebaskan driver jika ada
            if ($booking->driver_id) {
                $booking->driver?->update(['status' => 'available']);
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Konfirmasi pembayaran manual (bukti transfer dari customer)
     */
    public function confirmPayment(Request $request, Booking $booking)
    {
        // IDOR check
        if (auth('mitra')->check() && $booking->vehicle->mitra_id !== auth('mitra')->id()) {
            abort(403);
        }

        $request->validate([
            'payment_status'   => 'required|in:dp_paid,fully_paid,rejected',
            'rejection_reason' => 'required_if:payment_status,rejected|nullable|string',
        ]);

        $booking->payment()->update([
            'payment_status'   => $request->payment_status,
            'rejection_reason' => $request->rejection_reason,
            'payment_date'     => $request->payment_status !== 'rejected' ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}
