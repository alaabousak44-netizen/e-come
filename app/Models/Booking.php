<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'booking_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'booking_reference',
        'total_price',
        'booking_status',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function packageBookings(): HasMany
    {
        return $this->hasMany(PackageBooking::class, 'booking_id', 'booking_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'booking_id', 'booking_id');
    }

    public function getRouteKeyName(): string
    {
        return 'booking_id';
    }
}
