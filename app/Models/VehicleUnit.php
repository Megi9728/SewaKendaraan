<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleUnit extends Model
{
    protected $fillable = [
        'vehicle_id',
        'pool_id',
        'plate_number',
        'status',
        'latitude',
        'longitude',
        'last_tracked_at',
        'tracking_token',
    ];

    protected $casts = [
        'last_tracked_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->tracking_token = \Illuminate\Support\Str::random(32);
        });
    }

    // ─── Relasi ──────────────────────────────────────────────────────
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
