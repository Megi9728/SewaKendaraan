<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicle_units', function (Blueprint $table) {
            $table->string('tracking_token')->nullable()->unique()->after('status');
        });

        // Generate token for existing units
        $units = DB::table('vehicle_units')->get();
        foreach ($units as $unit) {
            DB::table('vehicle_units')->where('id', $unit->id)->update([
                'tracking_token' => Str::random(32)
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_units', function (Blueprint $table) {
            $table->dropColumn('tracking_token');
        });
    }
};
