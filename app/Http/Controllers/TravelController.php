<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class TravelController extends Controller
{
    private const DESTINATION_IMAGES = [
        'Bali' => 'https://unsplash.com/fr/photos/temple-brun-et-vert-pres-du-plan-deau-sous-ciel-nuageux-bleu-et-blanc-pendant-la-journee-bnMPFPuSCI0?utm_source=unsplash&utm_medium=referral&utm_content=creditShareLink',
        'Santorini' => 'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49a?w=600&q=80',
        'Kyoto' => 'https://images.unsplash.com/photo-1493976040374-85c8e912f1f7?w=600&q=80',
        'Marrakech' => 'https://images.unsplash.com/photo-1489749791429-7a0e6e3e0b1a?w=600&q=80',
        'Swiss Alps' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80',
        'Maldives' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80',
    ];

    public function home(): View
    {
        $packages = TravelPackage::with(['images', 'departureDates'])
            ->upcoming()
            ->orderBy('price_per_person')
            ->get();

        $destinations = $this->destinationsFromPackages($packages);

        $searchDestinations = TravelPackage::with('departureDates')
            ->upcoming()
            ->select('destination_city', 'destination_country')
            ->distinct()
            ->orderBy('destination_city')
            ->get()
            ->map(fn ($p) => "{$p->destination_city}, {$p->destination_country}");

        return view('travel', compact('packages', 'destinations', 'searchDestinations'));
    }

    public function search(Request $request): View
    {
        $packages = TravelPackage::with(['images', 'departureDates'])
            ->upcoming()
            ->forDestination($request->query('destination'))
            ->orderBy('price_per_person')
            ->get();

        return view('search-results', [
            'packages' => $packages,
            'destination' => $request->query('destination', 'Any destination'),
            'dates' => $request->query('dates', 'Flexible dates'),
            'travelers' => $request->query('travelers', '1 Adult'),
        ]);
    }

    public function show(TravelPackage $package): View
    {
        if (! $package->is_active || ! $package->next_departure_date) {
            abort(404);
        }

        $package->load(['images', 'departureDates']);

        return view('packages.show', compact('package'));
    }

    private function destinationsFromPackages($packages): array
    {
        $seen = [];

        return $packages
            ->unique(fn ($p) => $p->destination_city.'|'.$p->destination_country)
            ->take(6)
            ->map(function ($package) use ($packages, &$seen) {
                $key = $package->destination_city;
                if (isset($seen[$key])) {
                    return null;
                }
                $seen[$key] = true;

                $image = $package->images->first();
                if (! $image) {
                    $fallbackPackage = $packages->first(function ($candidate) use ($package) {
                        return $candidate->destination_city === $package->destination_city
                            && $candidate->destination_country === $package->destination_country
                            && $candidate->images->isNotEmpty();
                    });
                    $image = $fallbackPackage ? $fallbackPackage->images->first() : null;
                }

                return [
                    'name' => $package->destination_city,
                    'country' => $package->destination_country,
                    'package_id' => $package->package_id,
                    'price' => 'From $'.number_format($package->price_per_person, 0),
                    'img' => $image
                        ? asset('storage/' . $image->path)
                        : self::DESTINATION_IMAGES[$package->destination_city]
                            ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=600&q=80',
                    'tag' => $package->title ?: $package->destination_city,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
