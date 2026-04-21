<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus semua kolom terkait sopir dan pengantaran yang tidak terpakai lagi.
     */
    public function up(): void
    {
        // 1. Bookings: hapus kolom driver & delivery
        Schema::table('bookings', function (Blueprint $table) {
            // FK driver_id harus di-drop dulu sebelum kolom
            if (Schema::hasColumn('bookings', 'driver_id')) {
                $table->dropForeign(['driver_id']);
                $table->dropColumn('driver_id');
            }
            foreach (['with_driver', 'driver_price_snapshot', 'driver_rating', 'driver_review', 'delivery_type', 'delivery_location'] as $col) {
                if (Schema::hasColumn('bookings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        // 2. Vehicles: hapus kolom driver_price
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'driver_price')) {
                $table->dropColumn('driver_price');
            }
        });
    }

    /**
     * Kembalikan kolom jika diperlukan rollback.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('with_driver')->default(false);
            $table->integer('driver_price_snapshot')->nullable();
            $table->integer('driver_rating')->nullable();
            $table->text('driver_review')->nullable();
            $table->string('delivery_type')->default('self-pickup');
            $table->string('delivery_location')->nullable();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('driver_price')->default(150000);
        });
    }
};
