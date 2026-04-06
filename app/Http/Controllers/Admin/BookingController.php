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
            'status' => 'required|string|in:Pending,Confirmed,Active,Completed,Cancelled,Rejected,On_Delivery,Picked_Up,Waiting_Pickup,Returning,On_Pickup',
            'rejection_reason' => 'required_if:status,Rejected|nullable|string'
        ]);

        $newStatus = $request->status;

        // Update status booking
        $booking->update([
            'status' => $newStatus,
            'rejection_reason' => $request->rejection_reason ?? $booking->rejection_reason
        ]);

        // SINKRONISASI LOGIKA STATUS MOBIL
        $vehicle = $booking->vehicle;

        if (in_array($newStatus, ['Confirmed', 'Active', 'On_Delivery', 'Picked_Up', 'Waiting_Pickup', 'Returning', 'On_Pickup'])) {
            $vehicle->update(['status' => 'Disewa']);
        } 
        elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
            $vehicle->update(['status' => 'Tersedia']);
        }

        // SINKRONISASI LOGIKA STATUS DRIVER
        if ($booking->with_driver && $booking->driver_id) {
            $driver = $booking->driver;
            if (in_array($newStatus, ['Confirmed', 'On_Pickup', 'Picked_Up'])) {
                $driver->update(['status' => 'Busy']);
            } 
            elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
                $driver->update(['status' => 'Available']);
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
