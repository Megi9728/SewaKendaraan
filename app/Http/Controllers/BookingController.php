<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Helper: ambil customer yang sedang login
     */
    private function authCustomer()
    {
        return auth('customer')->user();
    }

    /**
     * Riwayat sewa customer
     */
    public function index()
    {
        $customer = $this->authCustomer();
        $bookings = Booking::with(['vehicle', 'payment', 'driver', 'vehicleUnit.pool'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('user.history', compact('bookings'));
    }

    /**
     * Halaman checkout
     */
    public function checkout(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);
        $hours = $start->diffInHours($end);
        $days  = ceil($hours / 24);
        if ($days < 1) $days = 1;

        $subtotal   = $vehicle->price_per_day * $days;
        $totalPrice = $subtotal;

        // Check overlapping driver bookings
        $overlappingDriverIds = Booking::whereNotNull('driver_id')
            ->whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->pluck('driver_id');

        // Sopir yang tersedia dari mitra kendaraan ini (tidak bentrok jadwal)
        $availableDrivers = Driver::where('mitra_id', $vehicle->mitra_id)
            ->where('status', '!=', 'off')
            ->whereNotIn('id', $overlappingDriverIds)
            ->get();

        $bookingData = [
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'days'        => $days,
            'subtotal'    => $subtotal,
            'total_price' => $totalPrice,
        ];

        return view('checkout', compact('vehicle', 'bookingData', 'availableDrivers'));
    }

    /**
     * Simpan booking baru
     */
    public function store(Request $request)
    {
        $customer = $this->authCustomer();

        $request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after:start_date',
            'driver_id'       => 'nullable|exists:drivers,id',
            'pickup_location' => 'nullable|string|max:255',
            'return_location' => 'nullable|string|max:255',
            'note'            => 'nullable|string',
            'ktp_photo'       => 'required_if:with_driver,0|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo'       => 'required_if:with_driver,0|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);
        $hours = $start->diffInHours($end);
        $days  = ceil($hours / 24);
        if ($days < 1) $days = 1;

        $totalPrice = $vehicle->price_per_day * $days;

        // Hitung biaya sopir jika dipilih
        $driverFee = 0;
        if ($request->driver_id || $request->with_driver == '1') {
            // Biaya sopir default: 150.000/hari (bisa dikonfigurasi per mitra)
            $driverFee = 150000 * $days;
            $totalPrice += $driverFee;
        }

        // Cari unit yang tersedia (tidak bentrok jadwal)
        $overlappingUnitIds = Booking::where('vehicle_id', $vehicle->id)
            ->whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->pluck('vehicle_unit_id');

        $unit = $vehicle->units()
            ->whereNotIn('id', $overlappingUnitIds)
            ->where('status', '!=', 'maintenance')
            ->first();

        if (!$unit) {
            return back()->with('error', 'Kendaraan ini sudah habis dipesan untuk rentang tanggal yang dipilih.');
        }

        // Handle File Uploads
        $ktpPath = null;
        $simPath = null;
        if ($request->hasFile('ktp_photo')) {
            $ktpPath = \App\Services\ImageService::storeWithWatermark($request->file('ktp_photo'), 'bookings/ktp');
        }
        if ($request->hasFile('sim_photo')) {
            $simPath = \App\Services\ImageService::storeWithWatermark($request->file('sim_photo'), 'bookings/sim');
        }

        // Buat booking
        $booking = Booking::create([
            'customer_id'     => $customer->id,
            'vehicle_id'      => $vehicle->id,
            'vehicle_unit_id' => $unit->id,
            'driver_id'       => $request->driver_id ?? null,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'days'            => $days,
            'extension'       => 0,
            'total_price'     => $totalPrice,
            'driver_fee'      => $driverFee,
            'overtime_fee'    => 0,
            'late_fee'        => 0,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'status'          => ($request->driver_id || $request->with_driver == '1') ? 'Confirmed' : 'Pending',
            'note'            => $request->note,
            'ktp_photo'       => $ktpPath,
            'sim_photo'       => $simPath,
        ]);

        // Buat record payment (status awal: unpaid)
        Payment::create([
            'booking_id'     => $booking->id,
            'payment_status' => Payment::STATUS_UNPAID,
            'amount'         => 0,
        ]);

        // Tidak perlu ubah status driver ke busy karena kita sudah cek overlapping date

        $msg = ($request->driver_id || $request->with_driver == '1')
            ? 'Pesanan berhasil dibuat! Silakan langsung lakukan pembayaran DP.'
            : 'Pesanan berhasil dibuat! Silakan tunggu verifikasi dokumen Anda.';

        return redirect()->route('booking.history')->with('success', $msg);
    }

    /**
     * Generate Midtrans Snap Token
     */
    public function getSnapToken(Request $request, Booking $booking)
    {
        $customer = $this->authCustomer();
        if ($booking->customer_id !== $customer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $payment = $booking->payment;
        $type    = $request->payment_type;
        $amount  = 0;

        if ($type === 'dp' && $payment->isUnpaid()) {
            $amount = ($booking->total_price + $booking->driver_fee) * 0.3;
        } elseif ($type === 'full' && $payment->isDpPaid()) {
            $amount = ($booking->total_price + $booking->driver_fee) * 0.7;
        } else {
            return response()->json(['error' => 'Status pembayaran tidak valid untuk aksi ini.'], 400);
        }

        \Midtrans\Config::$serverKey    = config('midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;
        \Midtrans\Config::$curlOptions  = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => [],
        ];

        $orderId = 'TRX-' . $booking->id . '-' . time() . '-' . strtoupper($type);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => round($amount),
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email'      => $customer->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Proses pembayaran (callback dari Midtrans frontend)
     */
    public function pay(Request $request, Booking $booking)
    {
        $customer = $this->authCustomer();
        if ($booking->customer_id !== $customer->id) abort(403);

        $payment = $booking->payment;
        $type    = $request->payment_type;

        if ($type === 'dp' && $payment->isUnpaid()) {
            $dpAmount = ($booking->total_price + $booking->driver_fee) * 0.3;
            $payment->update([
                'payment_status' => Payment::STATUS_DP_PAID,
                'amount'         => $dpAmount,
                'payment_method' => $request->payment_method ?? 'midtrans',
                'payment_date'   => now(),
            ]);
            return back()->with('success', 'Pembayaran DP 30% berhasil dikonfirmasi!');
        }

        if ($type === 'full' && $payment->isDpPaid()) {
            $fullAmount = ($booking->total_price + $booking->driver_fee) * 0.7;
            $payment->update([
                'payment_status' => Payment::STATUS_FULLY_PAID,
                'amount'         => $payment->amount + $fullAmount,
                'payment_date'   => now(),
            ]);
            return back()->with('success', 'Pelunasan berhasil dikonfirmasi!');
        }

        return back()->with('error', 'Pembayaran tidak valid.');
    }

    /**
     * Upload bukti pembayaran manual
     */
    public function uploadProof(Request $request, Booking $booking)
    {
        $customer = $this->authCustomer();
        if ($booking->customer_id !== $customer->id) abort(403);

        $request->validate([
            'proof_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_type'  => 'required|in:dp,full',
        ]);

        $path    = $request->file('proof_payment')->store('payments/proof', 'public');
        $payment = $booking->payment;

        $payment->update([
            'proof_payment'  => $path,
            'payment_method' => 'transfer',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi mitra.');
    }

    /**
     * Review & rating setelah selesai
     */
    public function review(Request $request, Booking $booking)
    {
        $customer = $this->authCustomer();
        if ($booking->customer_id !== $customer->id) abort(403);
        if ($booking->status !== 'Completed') {
            return back()->with('error', 'Hanya pesanan selesai yang dapat diulas.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $booking->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Update rata-rata rating kendaraan
        $vehicle          = $booking->vehicle;
        $allRatings       = Booking::where('vehicle_id', $vehicle->id)->whereNotNull('rating')->pluck('rating');
        if ($allRatings->count() > 0) {
            $vehicle->update([
                'rating'        => number_format($allRatings->average(), 1, '.', ''),
                'reviews_count' => $allRatings->count(),
            ]);
        }

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Bukti pesanan
     */
    public function receipt(Booking $booking)
    {
        $customer = $this->authCustomer();
        if ($booking->customer_id !== $customer->id) abort(403);

        $booking->load(['vehicle', 'customer', 'vehicleUnit.pool', 'driver', 'payment']);
        return view('user.receipt', compact('booking'));
    }

    /**
     * Update status pesanan oleh customer (misal: konfirmasi sudah ambil kendaraan)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $customer = $this->authCustomer();
        if ($booking->customer_id !== $customer->id) abort(403);

        $request->validate([
            'status' => 'required|string|in:Waiting_Pickup,Picked_Up,Returning',
        ]);

        $newStatus = $request->status;
        $booking->update(['status' => $newStatus]);

        // Sinkronisasi status unit
        if (in_array($newStatus, ['Picked_Up', 'Returning'])) {
            $booking->vehicleUnit?->update(['status' => 'disewa']);
        }

        if ($newStatus === 'Returning') {
            $booking->vehicleUnit?->update(['status' => 'tersedia']);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
