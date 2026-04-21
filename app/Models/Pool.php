<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $fillable = ['name', 'address'];

    public function vehicleUnits()
    {
        return $this->hasMany(VehicleUnit::class);
    }
}
