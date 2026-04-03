<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Tampilkan riwayat sewa pelanggan
     */
    public function index()
    {
        $bookings = Booking::with('vehicle')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.history', compact('bookings'));
    }

    /**
     * Proses pembuatan pesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Hitung durasi hari
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);
        
        if($days <= 0) $days = 1;

        // Hitung total harga
        $serviceFee = 50000;
        $totalPrice = ($vehicle->price_per_day * $days) + $serviceFee;

        // Simpan booking
        Booking::create([
            'user_id'     => Auth::id(),
            'vehicle_id'  => $vehicle->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'days'        => $days,
            'total_price' => $totalPrice,
            'status'      => 'Pending',
            'note'        => $request->note ?? null,
        ]);

        return redirect()->route('booking.history')->with('success', 'Pesanan Anda berhasil dikirim! Silakan tunggu konfirmasi admin.');
    }
}
