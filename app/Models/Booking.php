<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    // ─── Relasi ke Customer (tabel terpisah) ────────────────────────
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Backward-compat: beberapa blade masih pakai ->user
    public function user()
    {
        return $this->customer();
    }

    // ─── Relasi ke Vehicle ───────────────────────────────────────────
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // ─── Relasi ke VehicleUnit ───────────────────────────────────────
    public function vehicleUnit()
    {
        return $this->belongsTo(VehicleUnit::class);
    }

    // ─── Relasi ke Driver (opsional) ─────────────────────────────────
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    // ─── Relasi ke Payment ───────────────────────────────────────────
    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    // ─── Helpers ─────────────────────────────────────────────────────
    public function getPaymentStatusAttribute(): string
    {
        return $this->payment?->payment_status ?? 'unpaid';
    }

    public function getTotalFeeAttribute(): float
    {
        return (float) $this->total_price
            + (float) $this->driver_fee
            + (float) $this->overtime_fee
            + (float) $this->late_fee;
    }

    public function hasDriver(): bool
    {
        return !is_null($this->driver_id);
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['Active', 'Picked_Up', 'Returning', 'Waiting_Pickup']);
    }
}
