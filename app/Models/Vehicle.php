<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = []; // Baris ini WAJIB ada agar kita bisa memasukkan data dari Seeder.
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    /**
     * Menghitung jumlah unit yang benar-benar ada di garasi saat ini.
     * (Total unit - unit yang sedang disewa atau akan disewa hari ini).
     */
    public function getAvailableUnitsCountAttribute()
    {
        $taken = $this->bookings()
            ->whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        return max(0, ($this->units_count ?? 1) - $taken);
    }
}
