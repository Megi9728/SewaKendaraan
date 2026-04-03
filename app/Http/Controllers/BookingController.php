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
     * Tampilkan halaman checkout
     */
    public function checkout(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);
        if($days <= 0) $days = 1;

        $serviceFee = 50000;
        $subtotal = $vehicle->price_per_day * $days;
        $totalPrice = $subtotal + $serviceFee;

        $bookingData = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => $days,
            'subtotal' => $subtotal,
            'service_fee' => $serviceFee,
            'total_price' => $totalPrice,
        ];

        return view('checkout', compact('vehicle', 'bookingData'));
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
            'ktp_photo'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'delivery_type' => 'required|in:self-pickup,delivery',
            'delivery_location' => 'required_if:delivery_type,delivery|nullable|string',
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

        // Upload KTP & SIM
        $ktpPath = $request->file('ktp_photo')->store('verifikasi', 'public');
        $simPath = $request->file('sim_photo')->store('verifikasi', 'public');

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
            'ktp_photo'   => $ktpPath,
            'sim_photo'   => $simPath,
            'delivery_type' => $request->delivery_type,
            'delivery_location' => $request->delivery_type === 'delivery' ? $request->delivery_location : null,
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('booking.history')->with('success', 'Pesanan berhasil dibuat. KTP dan SIM Anda sedang diverifikasi admin sebelum Anda dapat membayar DP.');
    }

    /**
     * Proses pembayaran (Simulasi)
     */
    public function pay(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $type = $request->payment_type;
        if ($type === 'dp' && $booking->payment_status === 'unpaid') {
            $booking->update(['payment_status' => 'dp_paid']);
            return back()->with('success', 'Pembayaran DP 30% berhasil dikonfirmasi.');
        } elseif ($type === 'full' && $booking->payment_status === 'dp_paid') {
            $booking->update(['payment_status' => 'fully_paid']);
            return back()->with('success', 'Pelunasan berhasil dikonfirmasi.');
        }

        return back()->with('error', 'Pembayaran tidak valid.');
    }

    /**
     * Proses ulasan dan rating
     */
    public function review(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        if ($booking->status !== 'Completed') return back()->with('error', 'Hanya pesanan selesai yang dapat diulas.');

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ]);

        $booking->update([
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        // (Opsional) Update rata-rata rating kendaraan
        $vehicle = $booking->vehicle;
        $allRatings = Booking::where('vehicle_id', $vehicle->id)->whereNotNull('rating')->pluck('rating');
        if($allRatings->count() > 0) {
            $avg = $allRatings->average();
            $vehicle->update(['rating' => number_format($avg, 1, '.', '')]);
        }

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
