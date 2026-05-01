<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_status',
        'amount',
        'payment_date',
        'proof_payment',
        'rejection_reason',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    const STATUS_UNPAID    = 'unpaid';
    const STATUS_DP_PAID   = 'dp_paid';
    const STATUS_FULLY_PAID = 'fully_paid';
    const STATUS_REJECTED  = 'rejected';

    // Relasi
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    // Helpers
    public function isUnpaid(): bool    { return $this->payment_status === self::STATUS_UNPAID; }
    public function isDpPaid(): bool    { return $this->payment_status === self::STATUS_DP_PAID; }
    public function isFullyPaid(): bool { return $this->payment_status === self::STATUS_FULLY_PAID; }
}
