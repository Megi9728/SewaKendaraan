<?php

use Illuminate\Support\Facades\Route;

// ============================================================
// HALAMAN PUBLIK
// ============================================================

// Homepage / Beranda
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Jelajahi Semua Kendaraan
Route::get('/jelajahi', function () {
    return view('browse');
})->name('browse');

// Halaman Detail Kendaraan
Route::get('/kendaraan/{id}', function ($id) {
    return view('vehicle-detail', ['id' => $id]);
})->name('vehicle.detail');

// Halaman Cara Kerja
Route::get('/cara-kerja', function () {
    return view('how-it-works');
})->name('how.it.works');

// ============================================================
// AUTENTIKASI
// ============================================================

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// ============================================================
// HALAMAN ADMIN (protected - akan pakai middleware nanti)
// ============================================================

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/kendaraan', function () {
        return view('admin.vehicles.index');
    })->name('kendaraan');

    Route::get('/pemesanan', function () {
        return view('admin.bookings.index');
    })->name('pemesanan');

});