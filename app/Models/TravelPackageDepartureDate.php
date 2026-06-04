<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelPackageDepartureDate extends Model
{
    protected $table = 'travel_package_departure_dates';

    protected $primaryKey = 'departure_date_id';

    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'departure_date',
    ];

    protected $casts = [
        'departure_date' => 'date',
    ];

    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'package_id', 'package_id');
    }
}
