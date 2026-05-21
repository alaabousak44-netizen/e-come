<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Horizon Voyages — curated tours, flights, and unforgettable journeys worldwide.">
    <title>Horizon Voyages | Travel Agency</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-100">

    {{-- Navigation --}}
    <header id="main-nav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300 bg-transparent">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="#" class="flex items-center gap-2">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-ocean-700 text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span class="font-display text-xl font-semibold text-white sm:text-2xl">Horizon<span class="text-coral-400">Voyages</span></span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">
                <a href="#destinations" class="text-sm font-medium text-white/90 transition hover:text-coral-300">Destinations</a>
                <a href="#packages" class="text-sm font-medium text-white/90 transition hover:text-coral-300">Packages</a>
                <a href="#about" class="text-sm font-medium text-white/90 transition hover:text-coral-300">About</a>
                <a href="#testimonials" class="text-sm font-medium text-white/90 transition hover:text-coral-300">Reviews</a>
                <a href="{{ url('/login') }}" class="rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-white/10 transition hover:bg-white/20">Login / Sign Up</a>
            </nav>

            <button id="menu-btn" type="button" class="rounded-lg p-2 text-white md:hidden" aria-label="Toggle menu" aria-expanded="false">
                <svg id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="menu-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-white/10 bg-ocean-950/95 px-4 py-4 backdrop-blur-md md:hidden">
            <nav class="flex flex-col gap-3">
                <a href="#destinations" class="rounded-lg px-3 py-2 text-white/90 hover:bg-white/10">Destinations</a>
                <a href="#packages" class="rounded-lg px-3 py-2 text-white/90 hover:bg-white/10">Packages</a>
                <a href="#about" class="rounded-lg px-3 py-2 text-white/90 hover:bg-white/10">About</a>
                <a href="#testimonials" class="rounded-lg px-3 py-2 text-white/90 hover:bg-white/10">Reviews</a>
                <a href="#contact" class="mt-2 rounded-full bg-coral-500 px-4 py-3 text-center font-semibold text-white">Book a Trip</a>
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920&q=80"
                alt="Traveler overlooking a scenic landscape"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-b from-ocean-950/70 via-ocean-900/50 to-ocean-950/80"></div>
        </div>

        <div class="relative mx-auto flex min-h-screen max-w-7xl flex-col justify-center px-4 pb-24 pt-32 sm:px-6 lg:px-8">
            <p class="mb-4 inline-flex w-fit items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm text-white/90 backdrop-blur-sm">
                <span class="h-2 w-2 rounded-full bg-coral-400"></span>
                Trusted by 12,000+ travelers since 2010
            </p>
            <h1 class="font-display max-w-3xl text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                Discover the world,<br>
                <span class="italic text-coral-300">one journey at a time</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg text-white/80">
                Handcrafted itineraries, expert local guides, and seamless booking — from weekend escapes to once-in-a-lifetime adventures.
            </p>

            {{-- Search form --}}
            <form class="mt-10 w-full max-w-4xl rounded-2xl bg-white p-4 shadow-2xl shadow-ocean-950/20 sm:p-6" action="{{ url('/search-results') }}" method="GET">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="destination" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-ocean-700">Destination</label>
                        <select id="destination" name="destination" class="w-full rounded-xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                            <option>Bali, Indonesia</option>
                            <option>Santorini, Greece</option>
                            <option>Kyoto, Japan</option>
                            <option>Marrakech, Morocco</option>
                            <option>Swiss Alps</option>
                        </select>
                    </div>
                    <div>
                        <label for="dates" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-ocean-700">Travel dates</label>
                        <input type="date" id="dates" name="dates" class="w-full rounded-xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                    </div>
                    <div>
                        <label for="travelers" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-ocean-700">Travelers</label>
                        <select id="travelers" name="travelers" class="w-full rounded-xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                            <option>1 Adult</option>
                            <option>2 Adults</option>
                            <option>2 Adults, 1 Child</option>
                            <option>Family (4+)</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-xl bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:ring-offset-2">
                            Search Trips
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-12 flex flex-wrap gap-8 text-white/70">
                <div>
                    <p class="font-display text-3xl font-bold text-white">150+</p>
                    <p class="text-sm">Destinations</p>
                </div>
                <div>
                    <p class="font-display text-3xl font-bold text-white">4.9</p>
                    <p class="text-sm">Average rating</p>
                </div>
                <div>
                    <p class="font-display text-3xl font-bold text-white">24/7</p>
                    <p class="text-sm">Travel support</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Destinations --}}
    <section id="destinations" class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div data-reveal class="opacity-0 translate-y-6 transition-all duration-700">
                <p class="text-sm font-semibold uppercase tracking-widest text-ocean-600">Explore</p>
                <h2 class="font-display mt-2 text-3xl font-bold text-ocean-950 sm:text-4xl">Popular destinations</h2>
                <p class="mt-3 max-w-2xl text-ocean-700/80">From tropical beaches to ancient cities — find your next adventure among our most-loved spots.</p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                $destinations = [
                    ['name' => 'Bali', 'country' => 'Indonesia', 'price' => 'From $899', 'img' => 'https://images.unsplash.com/photo-1537996194474-f4c2f8a0c0c0?w=600&q=80', 'tag' => 'Beach & Culture'],
                    ['name' => 'Santorini', 'country' => 'Greece', 'price' => 'From $1,299', 'img' => 'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49a?w=600&q=80', 'tag' => 'Romance'],
                    ['name' => 'Kyoto', 'country' => 'Japan', 'price' => 'From $1,499', 'img' => 'https://images.unsplash.com/photo-1493976040374-85c8e912f1f7?w=600&q=80', 'tag' => 'Heritage'],
                    ['name' => 'Marrakech', 'country' => 'Morocco', 'price' => 'From $749', 'img' => 'https://images.unsplash.com/photo-1489749791429-7a0e6e3e0b1a?w=600&q=80', 'tag' => 'Adventure'],
                    ['name' => 'Swiss Alps', 'country' => 'Switzerland', 'price' => 'From $1,899', 'img' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80', 'tag' => 'Mountains'],
                    ['name' => 'Maldives', 'country' => 'Indian Ocean', 'price' => 'From $2,199', 'img' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80', 'tag' => 'Luxury'],
                ];
                @endphp

                @foreach ($destinations as $dest)
                <article data-reveal class="group opacity-0 translate-y-6 transition-all duration-700 overflow-hidden rounded-2xl bg-white shadow-md shadow-ocean-950/5 hover:shadow-xl">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $dest['img'] }}" alt="{{ $dest['name'] }}, {{ $dest['country'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-ocean-800 backdrop-blur-sm">{{ $dest['tag'] }}</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-display text-xl font-semibold text-ocean-950">{{ $dest['name'] }}</h3>
                                <p class="text-sm text-ocean-600">{{ $dest['country'] }}</p>
                            </div>
                            <p class="text-sm font-bold text-coral-600">{{ $dest['price'] }}</p>
                        </div>
                        <a href="#contact" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-ocean-700 transition hover:text-coral-600">
                            View details
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Packages --}}
    <section id="packages" class="bg-ocean-950 py-20 text-white sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div data-reveal class="text-center opacity-0 translate-y-6 transition-all duration-700">
                <p class="text-sm font-semibold uppercase tracking-widest text-coral-400">Curated for you</p>
                <h2 class="font-display mt-2 text-3xl font-bold sm:text-4xl">Travel packages</h2>
                <p class="mx-auto mt-3 max-w-2xl text-ocean-200">All-inclusive deals with flights, hotels, and guided experiences — no hidden fees.</p>
            </div>

            <div class="mt-14 grid gap-8 lg:grid-cols-3">
                @php
                $packages = [
                    ['name' => 'Explorer', 'duration' => '5 days', 'price' => '$1,199', 'features' => ['3-star boutique hotel', 'Daily breakfast', '2 guided tours', 'Airport transfers'], 'featured' => false],
                    ['name' => 'Adventurer', 'duration' => '10 days', 'price' => '$2,499', 'features' => ['4-star hotel + resort stay', 'All meals included', '5 guided experiences', 'Domestic flights', 'Travel insurance'], 'featured' => true],
                    ['name' => 'Luxury Escape', 'duration' => '14 days', 'price' => '$4,999', 'features' => ['5-star resorts & villas', 'Private chauffeur', 'Personal concierge', 'Premium excursions', 'Business-class flights'], 'featured' => false],
                ];
                @endphp

                @foreach ($packages as $pkg)
                <div data-reveal class="relative opacity-0 translate-y-6 transition-all duration-700 rounded-2xl border {{ $pkg['featured'] ? 'border-coral-500 bg-ocean-900 shadow-2xl shadow-coral-500/10 scale-105 lg:scale-110' : 'border-ocean-800 bg-ocean-900/50' }} p-8">
                    @if ($pkg['featured'])
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-coral-500 px-4 py-1 text-xs font-bold uppercase tracking-wide">Most popular</span>
                    @endif
                    <h3 class="font-display text-2xl font-semibold">{{ $pkg['name'] }}</h3>
                    <p class="mt-1 text-ocean-300">{{ $pkg['duration'] }}</p>
                    <p class="mt-6 font-display text-4xl font-bold text-coral-400">{{ $pkg['price'] }}<span class="text-base font-sans font-normal text-ocean-400"> / person</span></p>
                    <ul class="mt-8 space-y-3">
                        @foreach ($pkg['features'] as $feature)
                        <li class="flex items-center gap-3 text-sm text-ocean-100">
                            <svg class="h-5 w-5 shrink-0 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="#contact" class="mt-8 block w-full rounded-xl {{ $pkg['featured'] ? 'bg-coral-500 hover:bg-coral-600' : 'bg-ocean-700 hover:bg-ocean-600' }} py-3 text-center text-sm font-semibold transition">Get started</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why us --}}
    <section id="about" class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
                <div data-reveal class="opacity-0 translate-y-6 transition-all duration-700">
                    <p class="text-sm font-semibold uppercase tracking-widest text-ocean-600">Why Horizon Voyages</p>
                    <h2 class="font-display mt-2 text-3xl font-bold text-ocean-950 sm:text-4xl">Travel made simple, personal, and unforgettable</h2>
                    <p class="mt-4 text-ocean-700/80 leading-relaxed">
                        We're not just a booking platform — we're your travel partners. Every itinerary is tailored by specialists who've lived and breathed each destination.
                    </p>
                    <ul class="mt-8 space-y-5">
                        @foreach ([
                            ['title' => 'Expert local guides', 'desc' => 'Certified guides who share authentic stories and hidden gems.'],
                            ['title' => 'Flexible booking', 'desc' => 'Free date changes up to 14 days before departure.'],
                            ['title' => 'Best price guarantee', 'desc' => 'Find a lower price? We\'ll match it and give you 10% off.'],
                        ] as $item)
                        <li class="flex gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-ocean-100 text-ocean-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <h3 class="font-semibold text-ocean-950">{{ $item['title'] }}</h3>
                                <p class="mt-0.5 text-sm text-ocean-600">{{ $item['desc'] }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div data-reveal class="relative opacity-0 translate-y-6 transition-all duration-700">
                    <img src="https://images.unsplash.com/photo-1527631746617-bca8c9f1e0a0?w=800&q=80" alt="Happy travelers on a group tour" class="rounded-2xl shadow-2xl">
                    <div class="absolute -bottom-6 -left-4 rounded-2xl bg-white p-6 shadow-xl sm:-left-8">
                        <p class="font-display text-4xl font-bold text-ocean-700">15+</p>
                        <p class="text-sm font-medium text-ocean-600">Years of excellence</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section id="testimonials" class="bg-sand-200/50 py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div data-reveal class="text-center opacity-0 translate-y-6 transition-all duration-700">
                <p class="text-sm font-semibold uppercase tracking-widest text-ocean-600">Testimonials</p>
                <h2 class="font-display mt-2 text-3xl font-bold text-ocean-950 sm:text-4xl">Stories from our travelers</h2>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @php
                $reviews = [
                    ['name' => 'Sarah Mitchell', 'trip' => 'Bali Explorer', 'text' => 'Every detail was perfect — from the rice terrace hike to our beachfront villa. Horizon made our honeymoon magical.', 'avatar' => 'SM'],
                    ['name' => 'James Chen', 'trip' => 'Japan Heritage', 'text' => 'Our guide in Kyoto knew every temple\'s history. Best organized trip I\'ve ever taken. Already booked Switzerland!', 'avatar' => 'JC'],
                    ['name' => 'Elena Rodriguez', 'trip' => 'Greek Islands', 'text' => 'Santorini at sunset, private boat tour, incredible food. Worth every penny. Customer support was outstanding.', 'avatar' => 'ER'],
                ];
                @endphp

                @foreach ($reviews as $review)
                <blockquote data-reveal class="opacity-0 translate-y-6 transition-all duration-700 rounded-2xl bg-white p-6 shadow-md">
                    <div class="flex gap-1 text-coral-500">
                        @for ($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="mt-4 text-ocean-700/90 leading-relaxed">"{{ $review['text'] }}"</p>
                    <footer class="mt-6 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-ocean-700 text-sm font-bold text-white">{{ $review['avatar'] }}</span>
                        <div>
                            <cite class="not-italic font-semibold text-ocean-950">{{ $review['name'] }}</cite>
                            <p class="text-xs text-ocean-600">{{ $review['trip'] }}</p>
                        </div>
                    </footer>
                </blockquote>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact / CTA --}}
    <section id="contact" class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-ocean-800 to-ocean-950 shadow-2xl">
                <div class="grid lg:grid-cols-2">
                    <div data-reveal class="p-8 sm:p-12 lg:p-16 opacity-0 translate-y-6 transition-all duration-700">
                        <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">Ready for your next adventure?</h2>
                        <p class="mt-4 text-ocean-200">Tell us where you want to go. Our travel experts will craft a personalized quote within 24 hours.</p>
                        <form class="mt-8 space-y-4" action="#" method="post">
                            @csrf
                            <div class="grid gap-4 sm:grid-cols-2">
                                <input type="text" name="name" placeholder="Your name" required class="rounded-xl border-0 bg-white/10 px-4 py-3 text-white placeholder:text-ocean-300 focus:bg-white/15 focus:outline-none focus:ring-2 focus:ring-coral-400">
                                <input type="email" name="email" placeholder="Email address" required class="rounded-xl border-0 bg-white/10 px-4 py-3 text-white placeholder:text-ocean-300 focus:bg-white/15 focus:outline-none focus:ring-2 focus:ring-coral-400">
                            </div>
                            <input type="text" name="destination_interest" placeholder="Where would you like to go?" class="w-full rounded-xl border-0 bg-white/10 px-4 py-3 text-white placeholder:text-ocean-300 focus:bg-white/15 focus:outline-none focus:ring-2 focus:ring-coral-400">
                            <textarea name="message" rows="3" placeholder="Tell us about your dream trip..." class="w-full rounded-xl border-0 bg-white/10 px-4 py-3 text-white placeholder:text-ocean-300 focus:bg-white/15 focus:outline-none focus:ring-2 focus:ring-coral-400"></textarea>
                            <button type="submit" class="w-full rounded-xl bg-coral-500 py-3.5 font-semibold text-white transition hover:bg-coral-600 sm:w-auto sm:px-10">Request a quote</button>
                        </form>
                    </div>
                    <div class="relative hidden min-h-[320px] lg:block">
                        <img src="https://images.unsplash.com/photo-1469854523086-cc02eed5cfe9?w=800&q=80" alt="Scenic road trip" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-ocean-950/30"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-sand-300 bg-white py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <a href="#" class="font-display text-xl font-semibold text-ocean-950">Horizon<span class="text-coral-500">Voyages</span></a>
                    <p class="mt-3 text-sm text-ocean-600">Crafting memorable journeys across six continents since 2010.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-ocean-950">Explore</h4>
                    <ul class="mt-3 space-y-2 text-sm text-ocean-600">
                        <li><a href="#destinations" class="hover:text-coral-600">Destinations</a></li>
                        <li><a href="#packages" class="hover:text-coral-600">Packages</a></li>
                        <li><a href="#about" class="hover:text-coral-600">About us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-ocean-950">Contact</h4>
                    <ul class="mt-3 space-y-2 text-sm text-ocean-600">
                        <li>hello@horizonvoyages.com</li>
                        <li>+1 (800) 555-0199</li>
                        <li>123 Wander Lane, Suite 400<br>New York, NY 10001</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-ocean-950">Follow us</h4>
                    <div class="mt-3 flex gap-3">
                        @foreach (['instagram', 'facebook', 'twitter'] as $social)
                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-ocean-100 text-ocean-700 transition hover:bg-ocean-700 hover:text-white" aria-label="{{ ucfirst($social) }}">
                            <span class="text-xs font-bold uppercase">{{ substr($social, 0, 2) }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-10 border-t border-sand-200 pt-8 text-center text-sm text-ocean-500">
                &copy; {{ date('Y') }} Horizon Voyages. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
