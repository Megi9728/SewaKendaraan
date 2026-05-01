<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'mitra_id',
        'name',
        'phone',
        'address',
        'ktp_photo',
        'sim_photo',
        'driver_photo',
        'rating',
        'status',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
    ];

    // Relasi
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }

    // Scope
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
