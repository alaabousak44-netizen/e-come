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
                <div class="flex flex-wrap gap-2">
                    @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-ocean-200 bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-200">My Account</a>
                    @endauth
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-ocean-200 bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-200">Back to search</a>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-sand-50 p-4">
                    <p class="text-xs uppercase tracking-widest text-ocean-600">Destination</p>
                    <p class="mt-2 font-semibold text-ocean-950">{{ $destination ?: 'Any destination' }}</p>
                </div>
                <div class="rounded-2xl bg-sand-50 p-4">
                    <p class="text-xs uppercase tracking-widest text-ocean-600">Dates</p>
                    <p class="mt-2 font-semibold text-ocean-950">{{ $dates ?: 'Flexible dates' }}</p>
                </div>
                <div class="rounded-2xl bg-sand-50 p-4">
                    <p class="text-xs uppercase tracking-widest text-ocean-600">Travelers</p>
                    <p class="mt-2 font-semibold text-ocean-950">{{ $travelers }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-8">
            @forelse ($packages as $package)
            <article class="rounded-3xl bg-white p-8 shadow-lg shadow-ocean-950/5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-ocean-950">{{ $package->title }}</h2>
                        <p class="mt-1 text-sm text-ocean-600">{{ $package->destination_city }}, {{ $package->destination_country }}</p>
                        <p class="mt-2 text-sm text-ocean-600">Departs {{ $package->departure_date?->format('M j, Y') }}</p>
                        <p class="mt-2 text-sm text-ocean-600">{{ $package->description }}</p>
                    </div>
                    <div class="space-y-1 text-right">
                        <p class="text-sm uppercase tracking-widest text-ocean-600">Duration</p>
                        <p class="text-lg font-semibold text-coral-500">{{ $package->duration_days }} days</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-lg font-semibold text-ocean-950">Starting from ${{ number_format($package->price_per_person, 0) }} / person</p>
                    @auth
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('packages.show', $package) }}" class="inline-flex rounded-full bg-sand-100 px-6 py-3 text-sm font-semibold text-ocean-950 transition hover:bg-sand-200">View details</a>
                        <a href="{{ route('cart.add', ['package' => $package, 'dates' => $dates, 'travelers' => $travelers]) }}" class="inline-flex rounded-full bg-coral-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-coral-600">Add to cart</a>
                        <a href="{{ route('bookings.create', ['package' => $package, 'dates' => $dates, 'travelers' => $travelers]) }}" class="inline-flex rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Book &amp; pay</a>
                    </div>
                    @else
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('packages.show', $package) }}" class="inline-flex rounded-full bg-sand-100 px-6 py-3 text-sm font-semibold text-ocean-950 transition hover:bg-sand-200">View details</a>
                        <a href="{{ route('login') }}" class="inline-flex rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Login to add to cart</a>
                    </div>
                    @endauth
                </div>
            </article>
            @empty
            <div class="rounded-3xl bg-white p-8 text-center shadow-lg shadow-ocean-950/5">
                <p class="text-lg font-semibold text-ocean-950">No trips found</p>
                <p class="mt-2 text-sm text-ocean-600">Try another destination or browse all packages from the home page.</p>
                <a href="{{ url('/') }}" class="mt-6 inline-flex rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Back to home</a>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>
