<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = [];

    // ─── Relasi ──────────────────────────────────────────────────────
    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function units()
    {
        return $this->hasMany(VehicleUnit::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ─── Attribute Helpers ───────────────────────────────────────────
    /**
     * Hitung jumlah unit yang dapat beroperasi (tidak sedang maintenance)
     */
    public function getAvailableUnitsCountAttribute(): int
    {
        return $this->units()->where('status', '!=', 'maintenance')->count();
    }

    /**
     * Kembalikan daftar tanggal yang fully booked (semua unit sudah dipesan)
     */
    public function getFullyBookedDates(): array
    {
        $totalUnits = $this->units()->where('status', '!=', 'maintenance')->count();
        if ($totalUnits === 0) return [];

        $bookings = $this->bookings()
            ->whereNotIn('status', ['Cancelled', 'Rejected', 'Completed'])
            ->get();

        $dateCounts = [];
        foreach ($bookings as $booking) {
            $start = \Carbon\Carbon::parse($booking->start_date);
            $end   = \Carbon\Carbon::parse($booking->end_date);

            for ($date = clone $start; $date->lte($end); $date->addDay()) {
                $dateString = $date->format('Y-m-d');
                $dateCounts[$dateString] = ($dateCounts[$dateString] ?? 0) + 1;
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
