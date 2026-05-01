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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->integer('seats');
            $table->string('transmission');
            $table->string('fuel_type')->nullable();
            $table->integer('engine_capacity')->nullable();
            $table->integer('units_count')->default(1);
            $table->integer('price_per_day');
            $table->string('status')->default('Tersedia');
            $table->string('image')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('domicile')->default('Jakarta');
            $table->unsignedBigInteger('mitra_id')->nullable()->index('vehicles_mitra_id_foreign');
            $table->unsignedBigInteger('vehicle_category_id')->nullable()->index('vehicles_vehicle_category_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
