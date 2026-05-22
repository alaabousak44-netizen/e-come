<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Account') | Horizon Voyages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-100 text-ocean-950">
    <header class="border-b border-sand-300 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-ocean-700 text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span class="font-display text-xl font-semibold text-ocean-950">Horizon<span class="text-coral-500">Voyages</span></span>
            </a>

            <nav class="hidden items-center gap-6 md:flex">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-coral-600' : 'text-ocean-700 hover:text-ocean-950' }}">Dashboard</a>
                <a href="{{ route('bookings') }}" class="text-sm font-medium {{ request()->routeIs('bookings') ? 'text-coral-600' : 'text-ocean-700 hover:text-ocean-950' }}">My Bookings</a>
                <a href="{{ route('profile') }}" class="text-sm font-medium {{ request()->routeIs('profile') ? 'text-coral-600' : 'text-ocean-700 hover:text-ocean-950' }}">Profile</a>
                <a href="{{ route('home') }}" class="text-sm font-medium text-ocean-700 hover:text-ocean-950">Browse Trips</a>
            </nav>

            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-ocean-600 sm:inline">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-full border border-ocean-200 px-4 py-2 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Logout</button>
                </form>
            </div>
        </div>

        <nav class="flex gap-1 overflow-x-auto border-t border-sand-200 px-4 py-2 md:hidden">
            <a href="{{ route('dashboard') }}" class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-ocean-700 text-white' : 'bg-sand-100 text-ocean-700' }}">Dashboard</a>
            <a href="{{ route('bookings') }}" class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-semibold {{ request()->routeIs('bookings') ? 'bg-ocean-700 text-white' : 'bg-sand-100 text-ocean-700' }}">Bookings</a>
            <a href="{{ route('profile') }}" class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-semibold {{ request()->routeIs('profile') ? 'bg-ocean-700 text-white' : 'bg-sand-100 text-ocean-700' }}">Profile</a>
            <a href="{{ route('home') }}" class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-semibold bg-sand-100 text-ocean-700">Trips</a>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @if (session('success'))
        <div class="mb-6 rounded-2xl border border-ocean-200 bg-ocean-50 px-4 py-3 text-sm text-ocean-800">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
