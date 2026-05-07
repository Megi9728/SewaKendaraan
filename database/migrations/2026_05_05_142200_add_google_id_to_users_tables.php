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
        // Customers
        Schema::table('customers', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('avatar')->nullable()->after('profile_photo');
            $table->string('password')->nullable()->change(); // Google users won't have password
        });

        // Admins
        Schema::table('admins', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('avatar')->nullable()->after('profile_photo');
        });

        // Mitras
        Schema::table('mitras', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique()->after('email');
            $table->string('avatar')->nullable()->after('mitra_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
        });

        Schema::table('mitras', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
        });
    }
};
