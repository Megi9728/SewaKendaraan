<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. BUAT DATA USER (UNTUK LOGIN ADMIN)
        User::create([
            'name' => 'Admin RentDrive',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password123'), // Ini adalah cara aman menyimpan password
        ]);

        // 2. BUAT DATA KENDARAAN (CONTOH)
        Vehicle::create([
            'name' => 'Toyota Innova Zenix',
            'type' => 'MPV',
            'seats' => 7,
            'transmission' => 'Matic',
            'price_per_day' => 650000,
            'image' => 'https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=600',
            'rating' => 4.9,
            'reviews_count' => 128,
            'status' => 'Tersedia',
            'description' => 'Mobil keluarga premium dengan kenyamanan maksimal dan teknologi Hybrid terbaru.'
        ]);

        Vehicle::create([
            'name' => 'Honda PCX 160',
            'type' => 'Motor',
            'seats' => 2,
            'transmission' => 'Matic',
            'price_per_day' => 120000,
            'image' => 'https://images.unsplash.com/photo-1558981359-219d6364c9c8?auto=format&fit=crop&q=80&w=600',
            'rating' => 4.7,
            'reviews_count' => 210,
            'status' => 'Disewa',
            'description' => 'Motor matic bongsor yang sangat nyaman untuk berkeliling kota.'
        ]);

        Vehicle::create([
            'name' => 'Daihatsu Xenia',
            'type' => 'MPV',
            'seats' => 7,
            'transmission' => 'Manual',
            'price_per_day' => 380000,
            'image' => 'https://images.unsplash.com/photo-1603553329474-99f95f35394f?auto=format&fit=crop&q=80&w=600',
            'rating' => 4.5,
            'reviews_count' => 55,
            'status' => 'Tersedia',
            'description' => 'Mobil keluarga ekonomis yang tangguh untuk perjalanan jauh.'
        ]);
    }
}
