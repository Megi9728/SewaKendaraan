<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'ktp_photo',
        'sim_photo',
        'profile_photo',
        'google_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Helper
    public function isSuperAdmin(): bool { return false; }
    public function isMitra(): bool      { return false; }
    public function isCustomer(): bool   { return true; }
    public function isDriver(): bool     { return false; }

    // Relasi
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }
}
