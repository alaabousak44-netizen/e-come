<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageBooking extends Model
{
    protected $table = 'package_bookings';

    protected $primaryKey = 'package_booking_id';

    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'package_id',
        'travel_date',
        'number_of_travelers',
    ];

    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'package_id', 'package_id');
    }
}
