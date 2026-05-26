@extends('layouts.member')

@section('title', 'Admin dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-ocean-950">Admin dashboard</h1>
    <p class="mt-2 text-ocean-600">View usage statistics, manage destinations, and review users.</p>
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <p class="text-sm uppercase tracking-widest text-ocean-500">Total users</p>
        <p class="mt-4 text-4xl font-semibold text-ocean-950">{{ $totalUsers }}</p>
    </div>
    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <p class="text-sm uppercase tracking-widest text-ocean-500">Destinations</p>
        <p class="mt-4 text-4xl font-semibold text-ocean-950">{{ $totalPackages }}</p>
    </div>
    <div class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <p class="text-sm uppercase tracking-widest text-ocean-500">Bookings</p>
        <p class="mt-4 text-4xl font-semibold text-ocean-950">{{ $totalBookings }}</p>
    </div>
</div>

<div class="mt-10 grid gap-6 lg:grid-cols-3">
    <section class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Age distribution</h2>
        <div class="mt-5 space-y-3 text-sm text-ocean-700">
            @foreach($ageGroups as $group => $count)
                <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                    <span>{{ $group }}</span>
                    <strong>{{ $count }}</strong>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Region breakdown</h2>
        @if(count($regionDistribution) > 0)
            <div class="mt-5 space-y-3 text-sm text-ocean-700">
                @foreach($regionDistribution as $region => $count)
                    <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                        <span>{{ $region }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-5 text-sm text-ocean-600">No region data available yet.</p>
        @endif
    </section>

    <section class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Sex breakdown</h2>
        @if($hasProfileTable && count($genderDistribution) > 0)
            <div class="mt-5 space-y-3 text-sm text-ocean-700">
                @foreach($genderDistribution as $gender => $count)
                    <div class="flex items-center justify-between rounded-2xl bg-sand-50 px-4 py-3">
                        <span>{{ $gender }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-5 text-sm text-ocean-600">Sex data is not available until users add it to their profile.</p>
        @endif
    </section>
</div>

<div class="mt-10 grid gap-6 lg:grid-cols-2">
    <a href="{{ route('admin.packages.index') }}" class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200 transition hover:border-ocean-200">
        <h3 class="text-lg font-semibold text-ocean-950">Manage destinations</h3>
        <p class="mt-3 text-sm text-ocean-600">Add, edit, and remove the destinations shown to travelers.</p>
    </a>
    <a href="{{ route('admin.users.index') }}" class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200 transition hover:border-ocean-200">
        <h3 class="text-lg font-semibold text-ocean-950">Review users</h3>
        <p class="mt-3 text-sm text-ocean-600">See registered users, their profiles, and basic account details.</p>
    </a>
</div>
@endsection
