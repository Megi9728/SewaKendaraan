<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $fillable = [
        'mitra_id',
        'name',
        'address',
        'latitude',
        'longitude',
    ];

    // ─── Relasi ──────────────────────────────────────────────────────
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function vehicleUnits()
    {
        return $this->hasMany(VehicleUnit::class);
    }
}
