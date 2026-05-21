<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Trips | Horizon Voyages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-100 text-ocean-950">
    <div class="mx-auto min-h-screen max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-10 rounded-3xl bg-white p-8 shadow-lg shadow-ocean-950/5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-ocean-500">Search trips</p>
                    <h1 class="mt-2 text-3xl font-bold text-ocean-950">Available trip options</h1>
                    <p class="mt-2 text-sm text-ocean-600">Explore the available trips matching your search criteria.</p>
                </div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full border border-ocean-200 bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-200">Back to search</a>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-sand-50 p-4">
                    <p class="text-xs uppercase tracking-widest text-ocean-600">Destination</p>
                    <p class="mt-2 font-semibold text-ocean-950">{{ request('destination', 'Any destination') }}</p>
                </div>
                <div class="rounded-2xl bg-sand-50 p-4">
                    <p class="text-xs uppercase tracking-widest text-ocean-600">Dates</p>
                    <p class="mt-2 font-semibold text-ocean-950">{{ request('dates', 'Flexible dates') }}</p>
                </div>
                <div class="rounded-2xl bg-sand-50 p-4">
                    <p class="text-xs uppercase tracking-widest text-ocean-600">Travelers</p>
                    <p class="mt-2 font-semibold text-ocean-950">{{ request('travelers', '1 Adult') }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-8">
            @php
            $results = [
                ['title' => 'Bali Beach Escape', 'duration' => '7 days', 'price' => '$1,099', 'description' => 'Sun-soaked beaches, temples, and local food tours.'],
                ['title' => 'Santorini Sunset Retreat', 'duration' => '5 days', 'price' => '$1,299', 'description' => 'Romantic cliffside stays with wine tastings and private cruises.'],
                ['title' => 'Kyoto Culture Journey', 'duration' => '6 days', 'price' => '$1,450', 'description' => 'Ancient temples, guided city walks, and traditional tea ceremonies.'],
            ];
            @endphp

            @foreach ($results as $trip)
            <article class="rounded-3xl bg-white p-8 shadow-lg shadow-ocean-950/5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-ocean-950">{{ $trip['title'] }}</h2>
                        <p class="mt-2 text-sm text-ocean-600">{{ $trip['description'] }}</p>
                    </div>
                    <div class="space-y-1 text-right">
                        <p class="text-sm uppercase tracking-widest text-ocean-600">Duration</p>
                        <p class="text-lg font-semibold text-coral-500">{{ $trip['duration'] }}</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-lg font-semibold text-ocean-950">Starting from {{ $trip['price'] }}</p>
                    <a href="#" class="inline-flex rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">View details</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</body>
</html>
