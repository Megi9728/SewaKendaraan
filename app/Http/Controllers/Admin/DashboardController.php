<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mitra;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Models\VehicleUnit;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mitra'    => Mitra::count(),
            'total_vehicles' => Vehicle::count(),
            'total_bookings' => Booking::count(),
            'total_revenue'  => Payment::where('payment_status', 'fully_paid')->sum('amount'),
            'pending_bookings' => Booking::where('status', 'Pending')->count(),
            'rented_vehicles'=> VehicleUnit::where('status', 'disewa')->count(),
        ];
        $recentBookings = Booking::with(['customer', 'vehicle'])->latest()->take(5)->get();
        $topMitras = Mitra::withCount(['vehicles', 'bookings'])->orderByDesc('bookings_count')->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentBookings', 'topMitras'));
    }
}
