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
            $table->string('ktp_photo')->nullable();
            $table->string('sim_photo')->nullable();
            $table->string('delivery_type')->default('self-pickup');
            $table->string('delivery_location')->nullable();
            $table->string('payment_status')->default('unpaid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['ktp_photo', 'sim_photo', 'delivery_type', 'delivery_location', 'payment_status']);
        });
    }
};
