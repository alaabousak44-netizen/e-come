<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $package->title }} | Horizon Voyages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-100 text-ocean-950">
    <header class="border-b border-sand-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-semibold text-ocean-950">
                <svg class="h-6 w-6 text-coral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z"/>
                </svg>
                Horizon Voyages
            </a>
            <div class="flex items-center gap-3">
                @auth
                <a href="{{ route('cart.index') }}" class="rounded-full border border-ocean-200 bg-sand-50 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Cart ({{ count(session('cart', [])) }})</a>
                <a href="{{ route('dashboard') }}" class="rounded-full border border-ocean-200 bg-sand-50 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="rounded-full border border-ocean-200 bg-sand-50 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Login / Sign Up</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-widest text-ocean-600">Package details</p>
                <h1 class="mt-2 text-4xl font-bold text-ocean-950">{{ $package->title }}</h1>
                <p class="mt-2 text-sm text-ocean-600">{{ $package->destination_city }}, {{ $package->destination_country }} · {{ $package->duration_days }} days</p>
                <p class="mt-2 text-sm text-coral-500">Departure: {{ $package->departure_date ? \Illuminate\Support\Carbon::parse($package->departure_date)->format('M j, Y') : '' }}</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full bg-sand-100 px-5 py-3 text-sm font-semibold text-ocean-950 transition hover:bg-sand-200">
                <span>Back to packages</span>
            </a>
        </div>

        <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="space-y-8">
                <div class="rounded-3xl bg-white p-6 shadow-lg shadow-ocean-950/5">
                    <div class="grid gap-4 lg:grid-cols-[2fr_1fr]">
                        <div class="rounded-3xl overflow-hidden bg-sand-200">
                            @php $heroImage = $package->images->first(); @endphp
                            <img src="{{ $heroImage ? asset('storage/' . $heroImage->path) : 'https://via.placeholder.com/900x600?text=No+image' }}" alt="{{ $package->title }}" class="h-full w-full object-cover">
                        </div>
                        <div class="grid gap-3">
                            @foreach($package->images->skip(1)->take(4) as $image)
                            <div class="overflow-hidden rounded-3xl bg-sand-100">
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $package->title }} image" class="h-36 w-full object-cover">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-lg shadow-ocean-950/5">
                    <div class="flex items-center justify-between gap-4 border-b border-sand-200 pb-4">
                        <div>
                            <p class="text-sm uppercase tracking-widest text-ocean-600">Experience overview</p>
                            <h2 class="mt-2 text-2xl font-semibold text-ocean-950">What to expect</h2>
                        </div>
                        <p class="text-right text-lg font-bold text-coral-500">${{ number_format($package->price_per_person, 2) }} / person</p>
                    </div>
                    <p class="mt-6 leading-relaxed text-ocean-700">{{ $package->description }}</p>

                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-sand-200 bg-sand-50 p-5">
                            <p class="text-xs uppercase tracking-widest text-ocean-600">Duration</p>
                            <p class="mt-2 text-lg font-semibold text-ocean-950">{{ $package->duration_days }} days</p>
                        </div>
                        <div class="rounded-3xl border border-sand-200 bg-sand-50 p-5">
                            <p class="text-xs uppercase tracking-widest text-ocean-600">Max travelers</p>
                            <p class="mt-2 text-lg font-semibold text-ocean-950">{{ $package->max_capacity }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-8 shadow-lg shadow-ocean-950/5">
                    <p class="text-sm uppercase tracking-widest text-ocean-600">Ready to book?</p>
                    <h2 class="mt-2 text-2xl font-semibold text-ocean-950">Secure your place now</h2>
                    <p class="mt-4 text-sm text-ocean-700">Choose to book instantly or add this package to your cart and continue shopping first.</p>

                    <div class="mt-8 space-y-4">
                        @auth
                        <a href="{{ route('cart.add', ['package' => $package, 'dates' => now()->addDay()->format('Y-m-d'), 'travelers' => 1]) }}" class="block rounded-full bg-coral-500 px-6 py-4 text-center text-sm font-semibold text-white transition hover:bg-coral-600">Add to cart</a>
                        <a href="{{ route('bookings.create', $package) }}" class="block rounded-full bg-ocean-700 px-6 py-4 text-center text-sm font-semibold text-white transition hover:bg-ocean-800">Pay to book</a>
                        @else
                        <a href="{{ route('login') }}" class="block rounded-full bg-ocean-700 px-6 py-4 text-center text-sm font-semibold text-white transition hover:bg-ocean-800">Login to book</a>
                        <p class="mt-4 text-sm text-ocean-600">Create an account or sign in to add this package to your cart and complete booking.</p>
                        @endauth
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-8 shadow-lg shadow-ocean-950/5">
                    <p class="text-sm uppercase tracking-widest text-ocean-600">Package details</p>
                    <div class="mt-4 space-y-3 text-sm text-ocean-700">
                        <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                            <span>Destination</span>
                            <strong>{{ $package->destination_city }}, {{ $package->destination_country }}</strong>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                            <span>Duration</span>
                            <strong>{{ $package->duration_days }} days</strong>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                            <span>Price</span>
                            <strong>${{ number_format($package->price_per_person, 2) }}</strong>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                            <span>Capacity</span>
                            <strong>{{ $package->max_capacity }}</strong>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                            <span>Departure</span>
                            <strong>{{ $package->departure_date ? \Illuminate\Support\Carbon::parse($package->departure_date)->format('M j, Y') : '' }}</strong>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
