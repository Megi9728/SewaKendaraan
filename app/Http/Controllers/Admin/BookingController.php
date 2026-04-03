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
        $bookings = Booking::with(['user', 'vehicle'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update status pesanan & Sinkronisasi status mobil
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Confirmed,Active,Completed,Cancelled,Rejected',
            'rejection_reason' => 'required_if:status,Rejected|nullable|string'
        ]);

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        // Update status booking
        $booking->update([
            'status' => $newStatus,
            'rejection_reason' => $request->rejection_reason
        ]);

        // SINKRONISASI LOGIKA STATUS MOBIL
        $vehicle = $booking->vehicle;

        if (in_array($newStatus, ['Confirmed', 'Active'])) {
            // Jika disetujui atau sedang disewa, mobil jadi "Disewa"
            $vehicle->update(['status' => 'Disewa']);
        } 
        elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
            // Jika selesai atau batal, mobil balik jadi "Tersedia"
            $vehicle->update(['status' => 'Tersedia']);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan status armada telah disinkronkan!');
    }
}
