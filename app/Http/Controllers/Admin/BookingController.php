<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Tampilkan semua pesanan pelanggan (Admin)
     */
    public function index()
    {
        $query = Booking::with(['user', 'vehicle']);

        if (auth()->user()->isMitra()) {
            $mitraId = auth()->id();
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
     * Update status pesanan & Sinkronisasi status unit
     */
    public function update(Request $request, Booking $booking)
    {
        // Cegah Mitra mengedit pesanan milik Mitra lain (IDOR Protection)
        if (auth()->user()->isMitra() && $booking->vehicle->mitra_id !== auth()->id()) {
            return redirect()->back()->withErrors('Akses Dibatalkan: Anda hanya dapat mengelola pesanan untuk kendaraan Anda sendiri.');
        }

        $request->validate([
            'status'           => 'required|string|in:Pending,Confirmed,Active,Picked_Up,Returning,Completed,Cancelled,Rejected',
            'payment_status'   => 'nullable|string|in:unpaid,dp_paid,fully_paid',
            'rejection_reason' => 'required_if:status,Rejected|nullable|string',
        ]);

        $newStatus = $request->status;

        $booking->update([
            'status'           => $newStatus,
            'payment_status'   => $request->payment_status ?? $booking->payment_status,
            'rejection_reason' => $request->rejection_reason ?? $booking->rejection_reason,
        ]);

        // Sinkronisasi status unit kendaraan
        $vehicle = $booking->vehicle;

        if (in_array($newStatus, ['Confirmed', 'Active', 'Picked_Up', 'Returning'])) {
            if (in_array($newStatus, ['Active', 'Picked_Up', 'Returning']) && $booking->vehicleUnit) {
                $booking->vehicleUnit->update(['status' => 'disewa']);
            }
        } elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
            $vehicle->update(['status' => 'Tersedia']);
            if ($booking->vehicleUnit) {
                $booking->vehicleUnit->update(['status' => 'tersedia']);
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
