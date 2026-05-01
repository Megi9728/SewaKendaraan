<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Mitra;
use App\Models\Payment;
use App\Models\Pool;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. ADMIN ──────────────────────────────────────────────────
        Admin::create([
            'name'     => 'Admin RentDrive',
            'email'    => 'admin@gmail.com',
            'phone'    => '08100000001',
            'password' => Hash::make('password123'),
        ]);

        // ── 2. VEHICLE CATEGORIES ─────────────────────────────────────
        $catMobil = VehicleCategory::create([
            'name_kategori' => 'Mobil',
            'description'   => 'Kendaraan roda empat untuk keluarga maupun bisnis',
        ]);
        $catMotor = VehicleCategory::create([
            'name_kategori' => 'Motor',
            'description'   => 'Kendaraan roda dua untuk mobilitas harian',
        ]);
        $catBus = VehicleCategory::create([
            'name_kategori' => 'Bus / Minibus',
            'description'   => 'Kendaraan kapasitas besar untuk rombongan',
        ]);

        // ── 3. MITRA ──────────────────────────────────────────────────
        $mitra1 = Mitra::create([
            'name'        => 'Budi Santoso',
            'email'       => 'mitra@gmail.com',
            'phone'       => '08123456789',
            'address'     => 'Jl. Mitra Utama No. 1, Jakarta Pusat',
            'password'    => Hash::make('password123'),
            'is_verified' => true,
        ]);

        $mitra2 = Mitra::create([
            'name'        => 'Sari Dewi',
            'email'       => 'mitra2@gmail.com',
            'phone'       => '08234567890',
            'address'     => 'Jl. Usaha Baru No. 5, Bandung',
            'password'    => Hash::make('password123'),
            'is_verified' => true,
        ]);

        // ── 4. POOLS ──────────────────────────────────────────────────
        $pool1 = Pool::create([
            'mitra_id'  => $mitra1->id,
            'name'      => 'Pool Mitra Budi - Jakarta',
            'address'   => 'Jl. Mitra Utama No. 1, Jakarta Pusat',
            'latitude'  => -6.2088,
            'longitude' => 106.8456,
        ]);

        $pool2 = Pool::create([
            'mitra_id'  => $mitra2->id,
            'name'      => 'Pool Mitra Sari - Bandung',
            'address'   => 'Jl. Usaha Baru No. 5, Bandung',
            'latitude'  => -6.9175,
            'longitude' => 107.6191,
        ]);

        // ── 5. DRIVERS ────────────────────────────────────────────────
        $driver1 = Driver::create([
            'mitra_id' => $mitra1->id,
            'name'     => 'Agus Setiawan',
            'phone'    => '08111111111',
            'address'  => 'Jl. Sopir No. 1, Jakarta',
            'rating'   => 4.8,
            'status'   => 'available',
        ]);

        $driver2 = Driver::create([
            'mitra_id' => $mitra1->id,
            'name'     => 'Rudi Hartono',
            'phone'    => '08122222222',
            'address'  => 'Jl. Sopir No. 2, Jakarta',
            'rating'   => 4.6,
            'status'   => 'available',
        ]);

        // ── 6. VEHICLES ───────────────────────────────────────────────
        $v1 = Vehicle::create([
            'mitra_id'            => $mitra1->id,
            'vehicle_category_id' => $catMobil->id,
            'name'                => 'Toyota Innova Zenix',
            'type'                => 'MPV',
            'seats'               => 7,
            'transmission'        => 'Matic',
            'fuel_type'           => 'Hybrid',
            'engine_capacity'     => 2000,
            'domicile'            => 'Jakarta',
            'price_per_day'       => 650000,
            'image'               => 'https://images.unsplash.com/photo-1570733577524-3a047079e80d?auto=format&fit=crop&q=80&w=600',
            'rating'              => 4.9,
            'reviews_count'       => 128,
            'status'              => 'Tersedia',
            'description'         => 'Mobil keluarga premium dengan teknologi Hybrid terbaru.',
        ]);
        $v1->units()->create(['pool_id' => $pool1->id, 'plate_number' => 'B 1234 ABC', 'status' => 'tersedia']);
        $v1->units()->create(['pool_id' => $pool1->id, 'plate_number' => 'B 1235 ABC', 'status' => 'tersedia']);

        $v2 = Vehicle::create([
            'mitra_id'            => $mitra1->id,
            'vehicle_category_id' => $catMotor->id,
            'name'                => 'Honda PCX 160',
            'type'                => 'Motor',
            'seats'               => 2,
            'transmission'        => 'Matic',
            'fuel_type'           => 'Bensin',
            'engine_capacity'     => 160,
            'domicile'            => 'Jakarta',
            'price_per_day'       => 120000,
            'image'               => 'https://images.unsplash.com/photo-1558981359-219d6364c9c8?auto=format&fit=crop&q=80&w=600',
            'rating'              => 4.7,
            'reviews_count'       => 210,
            'status'              => 'Tersedia',
            'description'         => 'Motor matic premium yang nyaman untuk keliling kota.',
        ]);
        $v2->units()->create(['pool_id' => $pool1->id, 'plate_number' => 'B 5555 XYZ', 'status' => 'tersedia']);

        $v3 = Vehicle::create([
            'mitra_id'            => $mitra2->id,
            'vehicle_category_id' => $catMobil->id,
            'name'                => 'Daihatsu Xenia',
            'type'                => 'MPV',
            'seats'               => 7,
            'transmission'        => 'Manual',
            'fuel_type'           => 'Bensin',
            'engine_capacity'     => 1500,
            'domicile'            => 'Bandung',
            'price_per_day'       => 380000,
            'image'               => 'https://images.unsplash.com/photo-1603553329474-99f95f35394f?auto=format&fit=crop&q=80&w=600',
            'rating'              => 4.5,
            'reviews_count'       => 55,
            'status'              => 'Tersedia',
            'description'         => 'Mobil keluarga ekonomis yang tangguh untuk perjalanan jauh.',
        ]);
        $v3->units()->create(['pool_id' => $pool2->id, 'plate_number' => 'D 7777 LMN', 'status' => 'tersedia']);

        // ── 7. CUSTOMERS ──────────────────────────────────────────────
        $customer1 = Customer::create([
            'name'     => 'Andi Pratama',
            'email'    => 'customer@gmail.com',
            'phone'    => '08199999999',
            'address'  => 'Jl. Customer No. 5, Jakarta Selatan',
            'password' => Hash::make('password123'),
        ]);

        // ── 8. DRIVERS ────────────────────────────────────────────────
        \App\Models\Driver::create([
            'mitra_id' => $mitra1->id,
            'name'     => 'Supardi',
            'phone'    => '08123456780',
            'address'  => 'Jakarta Barat',
            'status'   => 'available',
        ]);
        \App\Models\Driver::create([
            'mitra_id' => $mitra1->id,
            'name'     => 'Jajang',
            'phone'    => '08123456781',
            'address'  => 'Jakarta Timur',
            'status'   => 'available',
        ]);
        \App\Models\Driver::create([
            'mitra_id' => $mitra2->id,
            'name'     => 'Dadang',
            'phone'    => '08223456782',
            'address'  => 'Dago, Bandung',
            'status'   => 'available',
        ]);

        // ── 8. SAMPLE BOOKING dengan PAYMENT ─────────────────────────
        $unit1   = $v1->units()->first();
        $booking = \App\Models\Booking::create([
            'customer_id'     => $customer1->id,
            'vehicle_id'      => $v1->id,
            'vehicle_unit_id' => $unit1->id,
            'driver_id'       => null, // self-pickup
            'start_date'      => now()->addDays(3)->toDateString(),
            'end_date'        => now()->addDays(6)->toDateString(),
            'days'            => 3,
            'extension'       => 0,
            'total_price'     => 1950000,
            'driver_fee'      => 0,
            'overtime_fee'    => 0,
            'late_fee'        => 0,
            'pickup_location' => 'Pool Jakarta Pusat',
            'return_location' => 'Pool Jakarta Pusat',
            'ktp_photo'       => 'bookings/ktp/sample_ktp.jpg',
            'sim_photo'       => 'bookings/sim/sample_sim.jpg',
            'status'          => 'Pending',
            'note'            => 'Mohon kendaraan dalam kondisi bersih.',
        ]);

        Payment::create([
            'booking_id'     => $booking->id,
            'payment_status' => Payment::STATUS_UNPAID,
            'amount'         => 0,
        ]);
    }
}
