@extends('layouts.member')

@section('title', 'Booking Confirmed')

@section('content')
@php
    $packageBooking = $booking->packageBookings->first();
    $package = $packageBooking?->travelPackage;
    $payment = $booking->payments->first();
@endphp

<div class="mx-auto max-w-2xl text-center">
    <div class="rounded-3xl bg-gradient-to-br from-ocean-700 to-ocean-950 p-10 text-white shadow-xl">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-coral-500">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="font-display mt-6 text-3xl font-bold">Booking confirmed!</h1>
        <p class="mt-4 text-ocean-100">Your trip has been booked and payment received. Details are saved to your account.</p>
    </div>

    <div class="mt-10 rounded-3xl bg-white p-8 text-left shadow-md">
        <dl class="space-y-4 text-sm">
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Booking reference</dt>
                <dd class="font-semibold text-ocean-950">{{ $booking->booking_reference }}</dd>
            </div>
            @if ($package)
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Trip</dt>
                <dd class="font-semibold text-ocean-950">{{ $package->title }}</dd>
            </div>
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Destination</dt>
                <dd class="font-semibold text-ocean-950">{{ $package->destination_city }}, {{ $package->destination_country }}</dd>
            </div>
            @endif
            @if ($packageBooking)
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Travel date</dt>
                <dd class="font-semibold text-ocean-950">{{ $packageBooking->travel_date->format('F j, Y') }}</dd>
            </div>
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Travelers</dt>
                <dd class="font-semibold text-ocean-950">{{ $packageBooking->number_of_travelers }}</dd>
            </div>
            @endif
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Total paid</dt>
                <dd class="font-semibold text-coral-600">${{ number_format($booking->total_price, 2) }}</dd>
            </div>
            @if ($payment)
            <div class="flex justify-between border-b border-sand-200 pb-3">
                <dt class="text-ocean-600">Payment method</dt>
                <dd class="font-semibold capitalize text-ocean-950">{{ str_replace('_', ' ', $payment->payment_method) }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-ocean-600">Transaction ID</dt>
                <dd class="font-mono text-xs font-semibold text-ocean-950">{{ $payment->transaction_reference }}</dd>
            </div>
            @endif
        </dl>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('bookings') }}" class="rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">View my bookings</a>
            <a href="{{ route('home') }}" class="rounded-full border border-ocean-200 px-6 py-3 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Book another trip</a>
        </div>
    </div>
</div>
@endsection
