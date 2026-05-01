<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mitra extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'ktp_photo',
        'mitra_photo',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'password'    => 'hashed',
    ];

    // Helper
    public function isSuperAdmin(): bool { return false; }
    public function isMitra(): bool      { return true; }
    public function isCustomer(): bool   { return false; }
    public function isDriver(): bool     { return false; }

    // Relasi
    public function pools()
    {
        return $this->hasMany(Pool::class, 'mitra_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'mitra_id');
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class, 'mitra_id');
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Vehicle::class, 'mitra_id', 'vehicle_id');
    }
}
