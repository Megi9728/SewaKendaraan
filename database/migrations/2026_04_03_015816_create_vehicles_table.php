<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Nama mobil: Toyota Innova
            $table->string('type');             // Jenis: MPV, Motor, dsb.
            $table->integer('seats');           // Kapasitas kursi
            $table->string('transmission');     // Manual / Matic
            $table->integer('price_per_day');   // Harga sewa per hari
            $table->string('status')->default('Tersedia'); // Status
            $table->string('image')->nullable(); // Link / Path Gambar
            $table->decimal('rating', 2, 1)->default(0); // Rating (misal 4.9)
            $table->integer('reviews_count')->default(0); // Jumlah ulasan
            $table->text('description')->nullable(); // Deskripsi kendaraan
            $table->timestamps(); // Created_at dan Updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
