<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    public $timestamps = true;

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'phone',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function profile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class, 'user_id', 'user_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id', 'user_id');
    }
}
