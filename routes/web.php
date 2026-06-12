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
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mitra\DashboardController as MitraDashboardController;

// ============================================================
// HALAMAN PUBLIK (Home, Browse, Detail)
// ============================================================

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/jelajah', [FrontendController::class, 'browse'])->name('browse');
Route::get('/mobil/{vehicle}', [FrontendController::class, 'vehicleDetail'])->name('vehicle.detail');
Route::get('/faq', [FrontendController::class, 'howItWorks'])->name('how.it.works');
Route::get('/bantuan', [FrontendController::class, 'help'])->name('help');

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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

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
    Route::get('/laporan/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('laporan.export');
});

// ============================================================
// AREA MITRA (guard: mitra)
// ============================================================

Route::middleware(['auth.role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');

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
    Route::get('/laporan/export', [\App\Http\Controllers\Mitra\ReportController::class, 'export'])->name('laporan.export');
});

// ============================================================
// GPS Tracker (Public - diakses device di kendaraan)
// ============================================================
Route::get('/tracker/{token}', [VehicleTrackingController::class, 'device'])->name('tracker.device');
Route::post('/tracking/update/{token}', [VehicleTrackingController::class, 'updateLocation'])->name('tracking.update');