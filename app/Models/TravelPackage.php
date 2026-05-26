<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPackage extends Model
{
    protected $table = 'travel_packages';

    protected $primaryKey = 'package_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'destination_city',
        'destination_country',
        'duration_days',
        'price_per_person',
        'max_capacity',
        'is_active',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'price_per_person' => 'decimal:2',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'package_id';
    }

    public function scopeForDestination($query, ?string $destination)
    {
        if (! $destination || $destination === 'Any destination') {
            return $query;
        }

        $parts = array_map('trim', explode(',', $destination, 2));
        $city = $parts[0] ?? '';
        $country = $parts[1] ?? '';

        return $query->where(function ($q) use ($city, $country, $destination) {
            $q->where('destination_city', 'like', "%{$city}%")
                ->orWhere('destination_country', 'like', "%{$country}%")
                ->orWhere('title', 'like', "%{$destination}%");
        });
    }
}
