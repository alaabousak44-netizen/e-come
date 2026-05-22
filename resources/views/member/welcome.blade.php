@extends('layouts.member')

@section('title', 'Welcome')

@section('content')
<div class="mx-auto max-w-3xl text-center">
    <div class="rounded-3xl bg-gradient-to-br from-ocean-700 to-ocean-950 p-10 text-white shadow-xl">
        <p class="text-sm font-semibold uppercase tracking-widest text-coral-300">Account created</p>
        <h1 class="font-display mt-4 text-4xl font-bold">Welcome, {{ $user->first_name }}!</h1>
        <p class="mt-4 text-lg text-ocean-100">
            Your Horizon Voyages account is ready. You can search trips, manage your profile, and track bookings from your member area.
        </p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('dashboard') }}" class="rounded-full bg-coral-500 px-8 py-3 text-sm font-semibold text-white transition hover:bg-coral-600">Go to dashboard</a>
            <a href="{{ route('home') }}" class="rounded-full border border-white/30 bg-white/10 px-8 py-3 text-sm font-semibold text-white transition hover:bg-white/20">Explore trips</a>
        </div>
    </div>

    <div class="mt-10 grid gap-4 text-left sm:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-md">
            <h2 class="font-semibold text-ocean-950">Dashboard</h2>
            <p class="mt-2 text-sm text-ocean-600">See your account overview and recent activity.</p>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-md">
            <h2 class="font-semibold text-ocean-950">My bookings</h2>
            <p class="mt-2 text-sm text-ocean-600">View trip reservations and booking status.</p>
        </div>
        <div class="rounded-2xl bg-white p-6 shadow-md">
            <h2 class="font-semibold text-ocean-950">Profile</h2>
            <p class="mt-2 text-sm text-ocean-600">Update your contact and travel details.</p>
        </div>
    </div>
</div>
@endsection
