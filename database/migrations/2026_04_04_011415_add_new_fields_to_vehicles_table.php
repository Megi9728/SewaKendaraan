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
            $table->string('fuel_type')->nullable()->after('transmission'); // Bensin, Diesel, dsb.
            $table->integer('engine_capacity')->nullable()->after('fuel_type'); // misal 1500 (cc)
            $table->integer('units_count')->default(1)->after('engine_capacity'); // Jumlah stok unit
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['fuel_type', 'engine_capacity', 'units_count']);
        });
    }
};
