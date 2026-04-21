<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'partner_name',
        'email',
        'phone',
        'address',
        'role',
        'is_verified',
        'password',
        'pool_id',
    ];

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'mitra_id');
    }


    public function isSuperAdmin() { return $this->role === 'superadmin' || $this->role === 'admin'; }
    public function isMitra()      { return $this->role === 'mitra'; }
    public function isCustomer()   { return $this->role === 'customer' || $this->role === 'user'; }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
