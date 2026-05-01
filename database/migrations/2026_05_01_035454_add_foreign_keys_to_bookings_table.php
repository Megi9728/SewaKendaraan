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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign(['customer_id'])->references(['id'])->on('customers')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['driver_id'])->references(['id'])->on('drivers')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['vehicle_id'])->references(['id'])->on('vehicles')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['vehicle_unit_id'])->references(['id'])->on('vehicle_units')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_customer_id_foreign');
            $table->dropForeign('bookings_driver_id_foreign');
            $table->dropForeign('bookings_vehicle_id_foreign');
            $table->dropForeign('bookings_vehicle_unit_id_foreign');
        });
    }
};
