@extends('layouts.member')

@section('title', 'My Bookings')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-ocean-950">My bookings</h1>
    <p class="mt-2 text-ocean-600">All your trip reservations in one place.</p>
</div>

<div class="space-y-6">
    @forelse ($bookings as $booking)
    <article class="rounded-3xl bg-white p-8 shadow-md">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Booking reference</p>
                <p class="mt-1 text-xl font-semibold text-ocean-950">{{ $booking->booking_reference }}</p>
                <p class="mt-1 text-sm text-ocean-600">Booked on {{ $booking->created_at?->format('F j, Y') }}</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-flex rounded-full bg-ocean-100 px-3 py-1 text-xs font-bold uppercase text-ocean-800">{{ $booking->booking_status }}</span>
                @if ($booking->payments->first())
                <p class="mt-1 text-xs text-ocean-500">Paid via {{ str_replace('_', ' ', $booking->payments->first()->payment_method) }}</p>
                @endif
                <p class="mt-2 text-2xl font-bold text-coral-600">${{ number_format($booking->total_price, 2) }}</p>
            </div>
        </div>

        @foreach ($booking->packageBookings as $packageBooking)
        @if ($packageBooking->travelPackage)
        <div class="mt-6 rounded-2xl bg-sand-50 p-5">
            <h2 class="text-lg font-semibold text-ocean-950">{{ $packageBooking->travelPackage->title }}</h2>
            <p class="mt-1 text-sm text-ocean-600">
                {{ $packageBooking->travelPackage->destination_city }}, {{ $packageBooking->travelPackage->destination_country }}
            </p>
            <div class="mt-3 flex flex-wrap gap-4 text-sm text-ocean-700">
                <span>Travel date: {{ $packageBooking->travel_date?->format('M j, Y') ?? 'TBD' }}</span>
                <span>Travelers: {{ $packageBooking->number_of_travelers }}</span>
                <span>Duration: {{ $packageBooking->travelPackage->duration_days }} days</span>
            </div>
        </div>
        @endif
        @endforeach
    </article>
    @empty
    <div class="rounded-3xl bg-white p-10 text-center shadow-md">
        <h2 class="text-xl font-semibold text-ocean-950">No bookings yet</h2>
        <p class="mt-2 text-ocean-600">When you book a trip, it will appear here.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Find a trip</a>
    </div>
    @endforelse
</div>
@endsection
