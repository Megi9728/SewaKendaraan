<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('drivers');
    }

    public function down(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('mitra_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->string('status')->default('Available'); // Available | Busy
            $table->timestamps();
        });
    }
};
