<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('driver_price')->default(150000)->after('price_per_day');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('with_driver')->default(false)->after('total_price');
            $table->integer('driver_price_snapshot')->nullable()->after('with_driver');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('driver_price');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['with_driver', 'driver_price_snapshot']);
        });
    }
};
