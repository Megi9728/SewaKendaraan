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

    public function units()
    {
        return $this->hasMany(VehicleUnit::class);
    }

    /**
     * Menghitung jumlah unit yang "tersedia" secara real
     */
    public function getAvailableUnitsCountAttribute()
    {
        // Karena ada relasi unit_mobil, kita bisa hitung berapa unit yang statusnya 'tersedia'
        return $this->units()->where('status', 'tersedia')->count();
    }
    public function getFullyBookedDates()
    {
        $totalUnits = $this->units()->where('status', '!=', 'maintenance')->count();
        if ($totalUnits === 0) return [];

        $bookings = $this->bookings()->whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])->get();
        
        $dateCounts = [];
        foreach ($bookings as $booking) {
            $start = \Carbon\Carbon::parse($booking->start_date);
            $end = \Carbon\Carbon::parse($booking->end_date);
            
            for ($date = clone $start; $date->lte($end); $date->addDay()) {
                $dateString = $date->format('Y-m-d');
                if (!isset($dateCounts[$dateString])) {
                    $dateCounts[$dateString] = 0;
                }
                $dateCounts[$dateString]++;
            }
        }

        $fullyBookedDates = [];
        foreach ($dateCounts as $date => $count) {
            if ($count >= $totalUnits) {
                $fullyBookedDates[] = $date;
            }
        }
        
        return $fullyBookedDates;
    }
}
