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
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled,Rejected'
        ]);

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        // Update status booking
        $booking->update([
            'status' => $newStatus
        ]);

        // SINKRONISASI LOGIKA STATUS MOBIL
        $vehicle = $booking->vehicle;

        if ($newStatus === 'Confirmed') {
            // Jika disetujui, mobil jadi "Disewa"
            $vehicle->update(['status' => 'Disewa']);
        } 
        elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
            // Jika selesai atau batal, mobil balik jadi "Tersedia"
            $vehicle->update(['status' => 'Tersedia']);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan status armada telah disinkronkan!');
    }
}
