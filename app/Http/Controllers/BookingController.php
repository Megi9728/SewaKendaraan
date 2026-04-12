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

        $serviceFee = 0;
        $subtotal = $vehicle->price_per_day * $days;
        $totalPrice = $subtotal;

        $bookingData = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => $days,
            'subtotal' => $subtotal,
            'service_fee' => $serviceFee,
            'total_price' => $totalPrice,
            'delivery_fee_amount' => 50000,
            'driver_price' => $vehicle->driver_price,
        ];

        $drivers = \App\Models\Driver::where('status', 'Available')->get();
        return view('checkout', compact('vehicle', 'bookingData', 'drivers'));
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
            'ktp_photo'  => 'required_without:with_driver|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo'  => 'required_without:with_driver|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'delivery_type' => 'required_without:with_driver|nullable|in:self-pickup,delivery',
            'delivery_location' => [\Illuminate\Validation\Rule::requiredIf(function () use ($request) {
                return $request->has('with_driver') || $request->delivery_type === 'delivery';
            }), 'nullable', 'string'],
            'with_driver' => 'nullable',
            'driver_id' => 'required_if:with_driver,1|nullable|exists:drivers,id',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Hitung durasi hari
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);
        
        if($days <= 0) $days = 1;

        // Hitung total harga
        $deliveryFee = $request->delivery_type === 'delivery' ? 50000 : 0;
        $driverFee = $request->has('with_driver') ? ($vehicle->driver_price * $days) : 0;
        $totalPrice = ($vehicle->price_per_day * $days) + $deliveryFee + $driverFee;

        // Upload KTP & SIM (Keduanya opsional jika pakai driver)
        $ktpPath = $request->hasFile('ktp_photo') ? $request->file('ktp_photo')->store('verifikasi', 'public') : null;
        $simPath = $request->hasFile('sim_photo') ? $request->file('sim_photo')->store('verifikasi', 'public') : null;

        // Cek bentrok jadwal (overlapping) untuk semua pesanan yang valid (belum dibatalkan/selesai)
        $overlappingBookings = \App\Models\Booking::where('vehicle_id', $vehicle->id)
            ->whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])
            ->where(function($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function($q2) use ($request) {
                          $q2->where('start_date', '<=', $request->start_date)
                             ->where('end_date', '>=', $request->end_date);
                      });
            })->pluck('vehicle_unit_id');

        // Cari 1 unit mobil yang TIDAK bentrok jadwalnya
        $unit = $vehicle->units()
            ->whereNotIn('id', $overlappingBookings)
            ->where('status', '!=', 'maintenance')
            ->first();

        if (!$unit) {
            return back()->with('error', 'Kendaraan ini sudah habis dipesan oleh orang lain untuk rentang tanggal yang dipilih.');
        }

        // Simpan booking
        Booking::create([
            'user_id'     => Auth::id(),
            'vehicle_id'  => $vehicle->id,
            'vehicle_unit_id' => $unit->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'days'        => $days,
            'total_price' => $totalPrice,
            'status'      => 'Pending',
            'note'        => $request->note ?? null,
            'ktp_photo'   => $ktpPath,
            'sim_photo'   => $simPath,
            'delivery_type' => $request->delivery_type ?? 'driver-service',
            'delivery_location' => $request->delivery_location,
            'payment_status' => 'unpaid',
            'with_driver' => $request->has('with_driver'),
            'driver_id' => $request->has('with_driver') ? $request->driver_id : null,
            'driver_price_snapshot' => $request->has('with_driver') ? $vehicle->driver_price : null,
        ]);

        return redirect()->route('booking.history')->with('success', 'Pesanan berhasil dibuat. KTP dan SIM Anda sedang diverifikasi admin sebelum Anda dapat membayar DP.');
    }

    /**
     * Proses pembayaran (Simulasi -> Callback via Frontend)
     */
    public function pay(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $type = $request->payment_type;
        if ($type === 'dp' && $booking->payment_status === 'unpaid') {
            $booking->update(['payment_status' => 'dp_paid']);
            return back()->with('success', 'Pembayaran DP 30% berhasil dikonfirmasi via Midtrans.');
        } elseif ($type === 'full' && $booking->payment_status === 'dp_paid') {
            $booking->update(['payment_status' => 'fully_paid']);
            return back()->with('success', 'Pelunasan berhasil dikonfirmasi via Midtrans.');
        }

        return back()->with('error', 'Pembayaran tidak valid.');
    }

    /**
     * Generate Midtrans Snap Token
     */
    public function getSnapToken(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $type = $request->payment_type;
        $amount = 0;

        if ($type === 'dp' && $booking->payment_status === 'unpaid') {
            $amount = $booking->total_price * 0.3;
        } elseif ($type === 'full' && $booking->payment_status === 'dp_paid') {
            $amount = $booking->total_price * 0.7;
        } else {
            return response()->json(['error' => 'Status pembayaran tidak valid untuk aksi ini.'], 400);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
        \Midtrans\Config::$curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => []
        ];

        $orderId = 'TRX-' . $booking->id . '-' . time() . '-' . strtoupper($type);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => round($amount),
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            'review' => 'nullable|string',
            'driver_rating' => 'nullable|integer|min:1|max:5',
            'driver_review' => 'nullable|string',
        ]);

        $booking->update([
            'rating' => $request->rating,
            'review' => $request->review,
            'driver_rating' => $request->driver_rating,
            'driver_review' => $request->driver_review,
        ]);

        // Update rata-rata rating dan jumlah ulasan kendaraan
        $vehicle = $booking->vehicle;
        $allVehicleRatings = Booking::where('vehicle_id', $vehicle->id)->whereNotNull('rating')->pluck('rating');
        if($allVehicleRatings->count() > 0) {
            $avg = $allVehicleRatings->average();
            $vehicle->update([
                'rating' => number_format($avg, 1, '.', ''),
                'reviews_count' => $allVehicleRatings->count()
            ]);
        }

        // Update rata-rata rating driver
        if ($booking->driver_id && $request->driver_rating) {
            $driver = $booking->driver;
            $allDriverRatings = Booking::where('driver_id', $driver->id)->whereNotNull('driver_rating')->pluck('driver_rating');
            if($allDriverRatings->count() > 0) {
                $avg = $allDriverRatings->average();
                $driver->update([
                    'rating' => number_format($avg, 1, '.', '')
                ]);
            }
        }

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Update status pesanan oleh pengguna
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $request->validate([
            'status' => 'nullable|string|in:Active,Waiting_Pickup,Returning,Picked_Up',
            'payment_status' => 'nullable|string|in:unpaid,dp_paid,fully_paid'
        ]);

        $newStatus = $request->status ?? $booking->status;
        $booking->update([
            'status' => $newStatus,
            'payment_status' => $request->payment_status ?? $booking->payment_status
        ]);

        // SINKRONISASI LOGIKA STATUS MOBIL
        $vehicle = $booking->vehicle;
        if (in_array($newStatus, ['Active', 'Picked_Up', 'Waiting_Pickup', 'Returning'])) {
            $vehicle->update(['status' => 'Disewa']);
        }

        if (in_array($newStatus, ['Completed', 'Cancelled', 'Rejected'])) {
            if ($booking->vehicleUnit) {
                $booking->vehicleUnit->update(['status' => 'tersedia']);
            }
        }

        // SINKRONISASI LOGIKA STATUS DRIVER
        if ($booking->with_driver && $booking->driver_id) {
            $driver = $booking->driver;
            if (in_array($newStatus, ['Picked_Up'])) {
                $driver->update(['status' => 'Busy']);
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
