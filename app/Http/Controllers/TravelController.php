<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelController extends Controller
{
    private const DESTINATION_IMAGES = [
        'Bali' => 'https://images.unsplash.com/photo-1537996194474-f4c2f8a0c0c0?w=600&q=80',
        'Santorini' => 'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49a?w=600&q=80',
        'Kyoto' => 'https://images.unsplash.com/photo-1493976040374-85c8e912f1f7?w=600&q=80',
        'Marrakech' => 'https://images.unsplash.com/photo-1489749791429-7a0e6e3e0b1a?w=600&q=80',
        'Swiss Alps' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80',
        'Maldives' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80',
    ];

    public function home(): View
    {
        $packages = TravelPackage::active()
            ->orderBy('price_per_person')
            ->get();

        $destinations = $this->destinationsFromPackages($packages);

        $searchDestinations = TravelPackage::active()
            ->select('destination_city', 'destination_country')
            ->distinct()
            ->orderBy('destination_city')
            ->get()
            ->map(fn ($p) => "{$p->destination_city}, {$p->destination_country}");

        return view('travel', compact('packages', 'destinations', 'searchDestinations'));
    }

    public function search(Request $request): View
    {
        $packages = TravelPackage::active()
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

    private function destinationsFromPackages($packages): array
    {
        $seen = [];

        return $packages
            ->unique(fn ($p) => $p->destination_city.'|'.$p->destination_country)
            ->take(6)
            ->map(function ($package) use (&$seen) {
                $key = $package->destination_city;
                if (isset($seen[$key])) {
                    return null;
                }
                $seen[$key] = true;

                return [
                    'name' => $package->destination_city,
                    'country' => $package->destination_country,
                    'price' => 'From $'.number_format($package->price_per_person, 0),
                    'img' => self::DESTINATION_IMAGES[$package->destination_city]
                        ?? 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=600&q=80',
                    'tag' => $package->title,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }
}
