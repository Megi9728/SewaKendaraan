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
        $bookings = Booking::with(['user', 'vehicle', 'driver'])->latest()->get();
        $drivers = \App\Models\Driver::where('status', 'Available')->get();
        return view('admin.bookings.index', compact('bookings', 'drivers'));
    }

    /**
     * Update status pesanan & Sinkronisasi status mobil
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Confirmed,Active,Completed,Cancelled,Rejected,On_Delivery,Picked_Up,Waiting_Pickup,Returning,On_Pickup',
            'payment_status' => 'nullable|string|in:unpaid,dp_paid,fully_paid',
            'rejection_reason' => 'required_if:status,Rejected|nullable|string',
            'driver_id' => 'nullable|exists:drivers,id'
        ]);


        $newStatus = $request->status;

        // Update status booking
        $booking->update([
            'status' => $newStatus,
            'payment_status' => $request->payment_status ?? $booking->payment_status,
            'rejection_reason' => $request->rejection_reason ?? $booking->rejection_reason,
            'driver_id' => $request->driver_id ?? $booking->driver_id
        ]);


        // SINKRONISASI LOGIKA STATUS MOBIL
        $vehicle = $booking->vehicle;

        if (in_array($newStatus, ['Confirmed', 'Active', 'On_Delivery', 'Picked_Up', 'Waiting_Pickup', 'Returning', 'On_Pickup'])) {
            $vehicle->update(['status' => 'Disewa']);
            // Fisik dikunci/disewakan jika mobil sedang dipakai atau sedang bersiap-siap jalan (bukan sekadar pending pesanan masa depan)
            if (in_array($newStatus, ['Active', 'On_Delivery', 'Picked_Up', 'Waiting_Pickup', 'Returning', 'On_Pickup']) && $booking->vehicleUnit) {
                $booking->vehicleUnit->update(['status' => 'disewa']);
            }
        } 
        elseif (in_array($newStatus, ['Completed', 'Rejected', 'Cancelled'])) {
            $vehicle->update(['status' => 'Tersedia']);
            if ($booking->vehicleUnit) {
                $booking->vehicleUnit->update(['status' => 'tersedia']);
            }
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
