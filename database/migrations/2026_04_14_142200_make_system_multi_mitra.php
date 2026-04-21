<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add mitra_id to vehicles
        Schema::table('vehicles', function (Blueprint $table) {
            $table->foreignId('mitra_id')->nullable()->constrained('users')->onDelete('set null')->after('id');
        });

        // Add mitra_id to drivers
        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('mitra_id')->nullable()->constrained('users')->onDelete('set null')->after('id');
        });

        // Add verification for mitra
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('role');
            $table->string('partner_name')->nullable()->after('name'); // Name of the rental business
            $table->text('address')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['mitra_id']);
            $table->dropColumn('mitra_id');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('mitra_id'); // Just to satisfy schema if needed
            $table->dropForeign(['mitra_id']);
            $table->dropColumn('mitra_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_verified', 'partner_name', 'address']);
        });
    }
};
