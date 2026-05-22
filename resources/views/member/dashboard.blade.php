@extends('layouts.member')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <p class="text-sm font-semibold uppercase tracking-widest text-ocean-500">Member area</p>
    <h1 class="mt-2 text-3xl font-bold text-ocean-950">Hello, {{ $user->first_name }}</h1>
    <p class="mt-2 text-ocean-600">Welcome back to your travel hub.</p>
</div>

<div class="grid gap-6 sm:grid-cols-3">
    <div class="rounded-2xl bg-white p-6 shadow-md">
        <p class="text-xs uppercase tracking-widest text-ocean-500">Total bookings</p>
        <p class="mt-2 text-3xl font-bold text-ocean-950">{{ $bookingCount }}</p>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-md">
        <p class="text-xs uppercase tracking-widest text-ocean-500">Email</p>
        <p class="mt-2 font-semibold text-ocean-950">{{ $user->email }}</p>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-md">
        <p class="text-xs uppercase tracking-widest text-ocean-500">Phone</p>
        <p class="mt-2 font-semibold text-ocean-950">{{ $user->phone ?: 'Not set' }}</p>
    </div>
</div>

<div class="mt-10 rounded-3xl bg-white p-8 shadow-md">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-ocean-950">Recent bookings</h2>
        <a href="{{ route('bookings') }}" class="text-sm font-semibold text-coral-600 hover:text-coral-700">View all</a>
    </div>

    <div class="mt-6 space-y-4">
        @forelse ($bookings as $booking)
        <div class="rounded-2xl border border-sand-200 p-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-semibold text-ocean-950">Ref: {{ $booking->booking_reference }}</p>
                    <p class="text-sm text-ocean-600">{{ $booking->created_at?->format('M j, Y') }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <span class="inline-flex rounded-full bg-ocean-100 px-3 py-1 text-xs font-semibold uppercase text-ocean-800">{{ $booking->booking_status }}</span>
                    <p class="mt-1 font-semibold text-coral-600">${{ number_format($booking->total_price, 2) }}</p>
                </div>
            </div>
            @foreach ($booking->packageBookings as $packageBooking)
            @if ($packageBooking->travelPackage)
            <p class="mt-3 text-sm text-ocean-700">{{ $packageBooking->travelPackage->title }} · {{ $packageBooking->number_of_travelers }} traveler(s)</p>
            @endif
            @endforeach
        </div>
        @empty
        <p class="text-ocean-600">You have no bookings yet. <a href="{{ route('home') }}" class="font-semibold text-coral-600 hover:text-coral-700">Search trips</a> to plan your next adventure.</p>
        @endforelse
    </div>
</div>

<div class="mt-8 grid gap-4 sm:grid-cols-2">
    <a href="{{ route('profile') }}" class="rounded-2xl border border-ocean-200 bg-ocean-50 p-6 transition hover:bg-ocean-100">
        <h3 class="font-semibold text-ocean-950">Edit profile</h3>
        <p class="mt-2 text-sm text-ocean-600">Update your personal and travel information.</p>
    </a>
    <a href="{{ route('home') }}" class="rounded-2xl border border-coral-200 bg-coral-50 p-6 transition hover:bg-coral-100">
        <h3 class="font-semibold text-ocean-950">Book a new trip</h3>
        <p class="mt-2 text-sm text-ocean-600">Browse destinations and travel packages.</p>
    </a>
</div>
@endsection
