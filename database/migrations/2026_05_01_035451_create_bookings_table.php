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
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id')->index('bookings_vehicle_id_foreign');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('days');
            $table->integer('extension')->default(0);
            $table->decimal('total_price', 12);
            $table->decimal('driver_fee', 12)->default(0);
            $table->decimal('overtime_fee', 12)->default(0);
            $table->decimal('late_fee', 12)->default(0);
            $table->string('status', 100)->nullable()->default('Pending');
            $table->text('note')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('return_location')->nullable();
            $table->timestamps();
            $table->string('ktp_photo')->nullable();
            $table->string('sim_photo')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->text('rejection_reason')->nullable();
            $table->integer('rating')->nullable();
            $table->text('review')->nullable();
            $table->unsignedBigInteger('vehicle_unit_id')->nullable()->index('bookings_vehicle_unit_id_foreign');
            $table->unsignedBigInteger('customer_id')->nullable()->index('bookings_customer_id_foreign');
            $table->unsignedBigInteger('driver_id')->nullable()->index('bookings_driver_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
