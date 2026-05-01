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
        Schema::table('vehicle_units', function (Blueprint $table) {
            $table->foreign(['pool_id'])->references(['id'])->on('pools')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['vehicle_id'])->references(['id'])->on('vehicles')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_units', function (Blueprint $table) {
            $table->dropForeign('vehicle_units_pool_id_foreign');
            $table->dropForeign('vehicle_units_vehicle_id_foreign');
        });
    }
};
