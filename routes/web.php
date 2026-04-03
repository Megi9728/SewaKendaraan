<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ============================================================
// HALAMAN PUBLIK (Home, Browse, Detail)
// ============================================================

Route::get('/', function () {
    $vehicles = \App\Models\Vehicle::latest()->take(3)->get();
    return view('home', compact('vehicles'));
})->name('home');

Route::get('/jelajah', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Vehicle::query();

    if ($request->filled('domicile')) {
        $query->where('domicile', $request->domicile);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $conflictingBookings = \App\Models\Booking::whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_date', '<=', $request->start_date)
                         ->where('end_date', '>=', $request->end_date);
                  });
            })
            ->pluck('vehicle_id');

        $query->whereNotIn('id', $conflictingBookings);
    }

    // Sort Logic
    $sort = $request->get('sort', 'latest');
    if ($sort === 'price_asc') {
        $query->orderBy('price_per_day', 'asc');
    } elseif ($sort === 'price_desc') {
        $query->orderBy('price_per_day', 'desc');
    } elseif ($sort === 'rating') {
        $query->orderBy('rating', 'desc');
    } else {
        $query->latest();
    }

    $vehicles = $query->get();
    return view('browse', compact('vehicles'));
})->name('browse');

Route::get('/mobil/{vehicle}', function (\App\Models\Vehicle $vehicle) {
    return view('vehicle-detail', compact('vehicle'));
})->name('vehicle.detail');

Route::get('/cara-kerja', function () {
    return view('how-it-works');
})->name('how.it.works');

Route::get('/bantuan', function () {
    return view('help');
})->name('help');

// ============================================================
// AUTENTIKASI
// ============================================================

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman User Terautentikasi (Profil & Booking)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Sistem Booking
    Route::get('/pesan/{vehicle}/checkout', [\App\Http\Controllers\BookingController::class, 'checkout'])->name('checkout');
    Route::post('/pesan', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
    Route::post('/pesan/{booking}/pay', [\App\Http\Controllers\BookingController::class, 'pay'])->name('booking.pay');
    Route::post('/pesan/{booking}/review', [\App\Http\Controllers\BookingController::class, 'review'])->name('booking.review');
    Route::put('/pesan/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('booking.status.update');
    Route::get('/riwayat-sewa', [\App\Http\Controllers\BookingController::class, 'index'])->name('booking.history');
});
// ============================================================
// HALAMAN ADMIN (protected with auth and admin middleware)
// ============================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $stats = [
            'total_vehicles' => \App\Models\Vehicle::count(),
            'pending_bookings' => \App\Models\Booking::where('status', 'Pending')->count(),
            'rented_vehicles' => \App\Models\Vehicle::where('status', 'Disewa')->count(),
            'total_revenue' => \App\Models\Booking::where('status', 'Completed')->sum('total_price'),
        ];
        
        $recentBookings = \App\Models\Booking::with(['user', 'vehicle'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    })->name('dashboard');

    // CRUD Kendaraan
    Route::get('/kendaraan', [\App\Http\Controllers\Admin\VehicleController::class, 'index'])->name('kendaraan');
    Route::post('/kendaraan', [\App\Http\Controllers\Admin\VehicleController::class, 'store'])->name('kendaraan.store');
    Route::put('/kendaraan/{vehicle}', [\App\Http\Controllers\Admin\VehicleController::class, 'update'])->name('kendaraan.update');
    Route::delete('/kendaraan/{vehicle}', [\App\Http\Controllers\Admin\VehicleController::class, 'destroy'])->name('kendaraan.destroy');

    // Profil Admin (Dashboard view)
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Manajemen Pemesanan
    Route::get('/pemesanan', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('pemesanan');
    Route::put('/pemesanan/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'update'])->name('pemesanan.update');

});