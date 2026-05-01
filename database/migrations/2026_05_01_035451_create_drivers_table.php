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
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mitra_id')->index('drivers_mitra_id_foreign');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('ktp_photo')->nullable();
            $table->string('sim_photo')->nullable();
            $table->string('driver_photo')->nullable();
            $table->decimal('rating', 3, 1)->default(5);
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
