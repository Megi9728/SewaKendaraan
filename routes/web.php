<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\VehicleTrackingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Mitra\DriverController;

// ============================================================
// HALAMAN PUBLIK (Home, Browse, Detail)
// ============================================================

Route::get('/', function () {
    $vehicles = \App\Models\Vehicle::with('category')->latest()->take(6)->get();
    return view('home', compact('vehicles'));
})->name('home');

Route::get('/jelajah', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Vehicle::with('category');

    if ($request->filled('category')) {
        $query->where('vehicle_category_id', $request->category);
    }

    if ($request->filled('domicile')) {
        $query->where('domicile', $request->domicile);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->where(function ($q) use ($request) {
            $q->whereRaw('(SELECT COUNT(*) FROM vehicle_units WHERE vehicle_units.vehicle_id = vehicles.id AND vehicle_units.status != "maintenance") > (
                SELECT COUNT(*) FROM bookings
                WHERE bookings.vehicle_id = vehicles.id
                AND status NOT IN ("Cancelled", "Rejected", "Completed")
                AND (
                    (start_date BETWEEN ? AND ?) OR
                    (end_date BETWEEN ? AND ?) OR
                    (start_date <= ? AND end_date >= ?)
                )
            )', [
                $request->start_date, $request->end_date,
                $request->start_date, $request->end_date,
                $request->start_date, $request->end_date,
            ]);
        });
    }

    $sort = $request->get('sort', 'latest');
    match ($sort) {
        'price_asc'  => $query->orderBy('price_per_day', 'asc'),
        'price_desc' => $query->orderBy('price_per_day', 'desc'),
        'rating'     => $query->orderBy('rating', 'desc'),
        default      => $query->latest(),
    };

    $vehicles   = $query->get();
    $categories = \App\Models\VehicleCategory::all();
    return view('browse', compact('vehicles', 'categories'));
})->name('browse');

Route::get('/mobil/{vehicle}', function (\App\Models\Vehicle $vehicle) {
    $vehicle->load(['images', 'mitra', 'units.pool', 'category', 'bookings' => function ($q) {
        $q->whereNotNull('review')->where('review', '!=', '')->with('customer')->latest();
    }]);
    return view('vehicle-detail', compact('vehicle'));
})->name('vehicle.detail');

Route::get('/faq', fn() => view('how-it-works'))->name('how.it.works');
Route::get('/bantuan', fn() => view('help'))->name('help');

// ============================================================
// AUTENTIKASI
// ============================================================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');

Route::get('/register/mitra', [AuthController::class, 'showRegisterMitra'])->name('register.mitra');
Route::post('/register/mitra', [AuthController::class, 'doRegisterMitra'])->name('register.mitra.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// ============================================================
// AREA CUSTOMER (guard: customer)
// ============================================================

Route::middleware(['auth.role:customer'])->group(function () {
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profil', [AuthController::class, 'destroyProfile'])->name('profile.destroy');

    // Booking
    Route::get('/pesan/{vehicle}/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/pesan', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/pesan/{booking}/snap-token', [BookingController::class, 'getSnapToken'])->name('booking.snap');
    Route::post('/pesan/{booking}/pay', [BookingController::class, 'pay'])->name('booking.pay');
    Route::post('/pesan/{booking}/proof', [BookingController::class, 'uploadProof'])->name('booking.proof');
    Route::post('/pesan/{booking}/review', [BookingController::class, 'review'])->name('booking.review');
    Route::put('/pesan/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.status.update');
    Route::get('/riwayat-sewa', [BookingController::class, 'index'])->name('booking.history');
    Route::get('/pesan/{booking}/bukti', [BookingController::class, 'receipt'])->name('booking.receipt');
});

// ============================================================
// AREA ADMIN (guard: admin)
// ============================================================

Route::middleware(['auth.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total_mitra'    => \App\Models\Mitra::count(),
            'total_vehicles' => \App\Models\Vehicle::count(),
            'total_bookings' => \App\Models\Booking::count(),
            'total_revenue'  => \App\Models\Payment::where('payment_status', 'fully_paid')->sum('amount'),
            'pending_bookings' => \App\Models\Booking::where('status', 'Pending')->count(),
            'rented_vehicles'=> \App\Models\VehicleUnit::where('status', 'disewa')->count(),
        ];
        $recentBookings = \App\Models\Booking::with(['customer', 'vehicle'])->latest()->take(5)->get();
        $topMitras = \App\Models\Mitra::withCount(['vehicles', 'bookings'])->orderByDesc('bookings_count')->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentBookings', 'topMitras'));
    })->name('dashboard');

    Route::get('/pemesanan', [AdminBookingController::class, 'index'])->name('booking.monitor');
    Route::put('/pemesanan/{booking}', [AdminBookingController::class, 'update'])->name('pemesanan.update');
    Route::post('/pemesanan/{booking}/payment', [AdminBookingController::class, 'confirmPayment'])->name('pemesanan.payment');

    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/{mitra}', [MitraController::class, 'show'])->name('mitra.show');
    Route::put('/mitra/{mitra}', [MitraController::class, 'update'])->name('mitra.update');
    Route::delete('/mitra/{mitra}', [MitraController::class, 'destroy'])->name('mitra.destroy');

    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profil', [AuthController::class, 'destroyProfile'])->name('profile.destroy');

    Route::resource('kendaraan', VehicleController::class)->parameters(['kendaraan' => 'vehicle']);
    Route::delete('/kendaraan/image/{image}', [VehicleController::class, 'destroyImage'])->name('kendaraan.destroyImage');
});

// ============================================================
// AREA MITRA (guard: mitra)
// ============================================================

Route::middleware(['auth.role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', function () {
        $mitra = auth('mitra')->user();
        $mitraId = $mitra->id;

        $stats = [
            'total_mobil'   => \App\Models\Vehicle::where('mitra_id', $mitraId)->count(),
            'total_booking' => \App\Models\Booking::whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))->count(),
            'pending'       => \App\Models\Booking::where('status', 'Pending')->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))->count(),
            'active'        => \App\Models\Booking::whereIn('status', ['Active', 'Picked_Up'])->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))->count(),
            'revenue'       => \App\Models\Payment::whereHas('booking.vehicle', fn($q) => $q->where('mitra_id', $mitraId))->where('payment_status', 'fully_paid')->sum('amount'),
            'total_drivers' => \App\Models\Driver::where('mitra_id', $mitraId)->count(),
        ];

        $chartData   = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month         = now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('F');
            $chartData[]   = \App\Models\Booking::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->whereHas('vehicle', fn($q) => $q->where('mitra_id', $mitraId))
                ->count();
        }

        return view('mitra.dashboard', compact('stats', 'chartData', 'chartLabels', 'mitra'));
    })->name('dashboard');

    // Kendaraan
    Route::resource('vehicles', VehicleController::class);
    Route::delete('/vehicles/image/{image}', [VehicleController::class, 'destroyImage'])->name('vehicles.destroyImage');

    // Pemesanan
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::put('/booking/{booking}', [AdminBookingController::class, 'update'])->name('booking.update');
    Route::post('/booking/{booking}/payment', [AdminBookingController::class, 'confirmPayment'])->name('booking.payment');

    // Sopir
    Route::resource('drivers', DriverController::class)->names('drivers');

    // Profil
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profil', [AuthController::class, 'destroyProfile'])->name('profile.destroy');

    // GPS Monitoring
    Route::get('/monitoring', [VehicleTrackingController::class, 'monitor'])->name('monitoring');
});

// ============================================================
// GPS Tracker (Public - diakses device di kendaraan)
// ============================================================
Route::get('/tracker/{token}', [VehicleTrackingController::class, 'device'])->name('tracker.device');
Route::post('/tracking/update/{token}', [VehicleTrackingController::class, 'updateLocation'])->name('tracking.update');