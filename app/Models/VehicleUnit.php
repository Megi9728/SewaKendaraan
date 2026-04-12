<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleUnit extends Model
{
    protected $fillable = ['vehicle_id', 'pool_id', 'plate_number', 'status'];

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
