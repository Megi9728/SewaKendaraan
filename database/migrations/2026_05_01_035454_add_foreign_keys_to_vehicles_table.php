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
            $table->foreign(['mitra_id'])->references(['id'])->on('mitras')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['vehicle_category_id'])->references(['id'])->on('vehicle_categories')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign('vehicles_mitra_id_foreign');
            $table->dropForeign('vehicles_vehicle_category_id_foreign');
        });
    }
};
