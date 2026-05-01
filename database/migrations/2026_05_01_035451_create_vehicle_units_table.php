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
        Schema::create('vehicle_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id')->index('vehicle_units_vehicle_id_foreign');
            $table->unsignedBigInteger('pool_id')->index('vehicle_units_pool_id_foreign');
            $table->string('plate_number')->nullable();
            $table->string('status')->default('tersedia');
            $table->string('tracking_token')->nullable()->unique();
            $table->timestamps();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('last_tracked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_units');
    }
};
