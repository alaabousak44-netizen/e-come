<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
        'departure_date',
        'created_at',
    ];

    protected $casts = [
        'price_per_person' => 'decimal:2',
        'is_active' => 'boolean',
        'departure_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function departureDates(): HasMany
    {
        return $this->hasMany(TravelPackageDepartureDate::class, 'package_id', 'package_id')->orderBy('departure_date');
    }

    public function upcomingDepartureDates(): HasMany
    {
        return $this->departureDates()->whereDate('departure_date', '>=', now()->toDateString());
    }

    public function getNextDepartureDateAttribute()
    {
        $nextDate = $this->departureDates()
            ->whereDate('departure_date', '>=', now()->addWeek()->toDateString())
            ->orderBy('departure_date')
            ->first();

        return $nextDate ? $nextDate->departure_date : null;
    }

    public function syncDepartureDates(array $dates): void
    {
        $normalized = collect($dates)
            ->filter()
            ->map(fn ($date) => Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->sort()
            ->values()
            ->all();

        $this->departureDates()->whereNotIn('departure_date', $normalized)->delete();

        foreach ($normalized as $date) {
            $this->departureDates()->firstOrCreate(['departure_date' => $date]);
        }

        $this->departure_date = reset($normalized) ?: null;
        $this->save();
    }

    public function scopeUpcoming($query)
    {
        return $query->active()
            ->whereHas('departureDates', function ($query) {
                $query->whereDate('departure_date', '>=', now()->addWeek()->toDateString());
            });
    }

    public function images()
    {
        return $this->hasMany(TravelPackageImage::class, 'package_id');
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
