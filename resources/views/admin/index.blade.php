@extends('layouts.member')

@section('title', 'Admin dashboard')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-bold text-ocean-950">Admin Dashboard</h1>
        <p class="mt-2 text-ocean-600 max-w-xl">Overview of key metrics and quick actions to manage destinations, users and bookings. Clean, focused and actionable.</p>
    </div>
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center gap-2 rounded-full bg-ocean-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-ocean-800">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add destination
        </a>
        <a href="{{ route('admin.packages.index') }}" class="rounded-full bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Manage</a>
        <a href="{{ route('admin.requests.index') }}" class="rounded-full bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Requests</a>
        <a href="{{ route('admin.users.index') }}" class="rounded-full bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Users</a>
    </div>
</div>

<div class="grid gap-6 md:grid-cols-3">
    <div class="rounded-2xl bg-white p-6 shadow border border-sand-200 flex items-center gap-4">
        <div class="rounded-lg bg-ocean-50 p-3">
            <svg class="h-6 w-6 text-ocean-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13 13 0 1118.879 6.196 13 13 0 015.12 17.804z"/></svg>
        </div>
        <div>
            <p class="text-sm uppercase tracking-widest text-ocean-500">Total users</p>
            <p class="mt-1 text-2xl font-semibold text-ocean-950">{{ $totalUsers }}</p>
            <p class="mt-1 text-xs text-ocean-600">Registered users on platform</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow border border-sand-200 flex items-center gap-4">
        <div class="rounded-lg bg-green-50 p-3">
            <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3 8 4-16 3 8h4"/></svg>
        </div>
        <div>
            <p class="text-sm uppercase tracking-widest text-ocean-500">Destinations</p>
            <p class="mt-1 text-2xl font-semibold text-ocean-950">{{ $totalPackages }}</p>
            <p class="mt-1 text-xs text-ocean-600">Active travel packages</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow border border-sand-200 flex items-center gap-4">
        <div class="rounded-lg bg-amber-50 p-3">
            <svg class="h-6 w-6 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
        </div>
        <div>
            <p class="text-sm uppercase tracking-widest text-ocean-500">Bookings</p>
            <p class="mt-1 text-2xl font-semibold text-ocean-950">{{ $totalBookings }}</p>
            <p class="mt-1 text-xs text-ocean-600">Confirmed reservations</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow border border-sand-200 flex items-center gap-4">
        <div class="rounded-lg bg-purple-50 p-3">
            <svg class="h-6 w-6 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <p class="text-sm uppercase tracking-widest text-ocean-500">Requests</p>
            <p class="mt-1 text-2xl font-semibold text-ocean-950">{{ $totalRequests }}</p>
            <p class="mt-1 text-xs text-ocean-600">User travel requests submitted</p>
        </div>
    </div>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-3">
    <section class="rounded-2xl bg-white p-6 shadow border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Age Distribution</h2>
        <div class="mt-4 space-y-3 text-sm text-ocean-700">
            @foreach($ageGroups as $group => $count)
                @php $pct = $totalUsers ? round(($count / $totalUsers) * 100) : 0; @endphp
                <div>
                    <div class="flex justify-between text-sm text-ocean-800 mb-1">
                        <span>{{ $group }}</span>
                        <strong>{{ $count }} <span class="text-ocean-500">({{ $pct }}%)</span></strong>
                    </div>
                    <div class="h-2 w-full rounded-full bg-sand-50">
                        <div class="h-2 rounded-full bg-ocean-700" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 shadow border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Region Breakdown</h2>
        @if(count($regionDistribution) > 0)
            <div class="mt-4 space-y-3 text-sm text-ocean-700">
                @foreach($regionDistribution as $region => $count)
                    @php $pct = $totalUsers ? round(($count / $totalUsers) * 100) : 0; @endphp
                    <div>
                        <div class="flex justify-between text-sm text-ocean-800 mb-1">
                            <span>{{ $region }}</span>
                            <strong>{{ $count }} <span class="text-ocean-500">({{ $pct }}%)</span></strong>
                        </div>
                        <div class="h-2 w-full rounded-full bg-sand-50">
                            <div class="h-2 rounded-full bg-green-600" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-ocean-600">No region data available yet.</p>
        @endif
    </section>

    <section class="rounded-2xl bg-white p-6 shadow border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Sex Breakdown</h2>
        @if($hasProfileTable && count($genderDistribution) > 0)
            <div class="mt-4 space-y-3 text-sm text-ocean-700">
                @foreach($genderDistribution as $gender => $count)
                    @php $pct = $totalUsers ? round(($count / $totalUsers) * 100) : 0; @endphp
                    <div>
                        <div class="flex justify-between text-sm text-ocean-800 mb-1">
                            <span>{{ $gender }}</span>
                            <strong>{{ $count }} <span class="text-ocean-500">({{ $pct }}%)</span></strong>
                        </div>
                        <div class="h-2 w-full rounded-full bg-sand-50">
                            <div class="h-2 rounded-full bg-amber-600" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mt-4 text-sm text-ocean-600">Sex data is not available until users update their profile.</p>
        @endif
    </section>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <section class="rounded-2xl bg-white p-6 shadow border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Latest Snapshot</h2>
        <p class="mt-2 text-sm text-ocean-600">A quick summary of recent counts for rapid assessment.</p>
        <div class="mt-4 space-y-3 text-sm">
            <div class="flex items-center justify-between rounded-lg bg-sand-50 px-4 py-3">
                <span class="text-ocean-800">Total users</span>
                <strong class="text-ocean-950">{{ $totalUsers }}</strong>
            </div>
            <div class="flex items-center justify-between rounded-lg bg-sand-50 px-4 py-3">
                <span class="text-ocean-800">Total destinations</span>
                <strong class="text-ocean-950">{{ $totalPackages }}</strong>
            </div>
            <div class="flex items-center justify-between rounded-lg bg-sand-50 px-4 py-3">
                <span class="text-ocean-800">Total bookings</span>
                <strong class="text-ocean-950">{{ $totalBookings }}</strong>
            </div>
        </div>
    </section>

    <section class="rounded-2xl bg-white p-6 shadow border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Quick Actions</h2>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            <a href="{{ route('admin.packages.create') }}" class="rounded-lg bg-ocean-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Add destination</a>
            <a href="{{ route('admin.packages.index') }}" class="rounded-lg bg-sand-100 px-4 py-3 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Manage destinations</a>
            <a href="{{ route('admin.users.index') }}" class="rounded-lg bg-sand-100 px-4 py-3 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Review users</a>
            <a href="{{ route('dashboard') }}" class="rounded-lg bg-sand-100 px-4 py-3 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Member dashboard</a>
        </div>
        <p class="mt-4 text-xs text-ocean-500">Admin menu appears only for accounts that satisfy `User::isAdmin()`.</p>
    </section>
</div>

<div class="mt-8 rounded-2xl bg-white p-6 shadow border border-sand-200">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-ocean-950">Recent bookings</h2>
            <p class="mt-2 text-sm text-ocean-600">Orders placed by customers with package and payment details.</p>
        </div>
        <div>
            <a href="{{ route('admin.requests.index') }}" class="rounded-full bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">View all requests</a>
        </div>
    </div>

    @if($latestBookings->isEmpty())
        <p class="mt-6 text-sm text-ocean-600">No bookings have been created yet.</p>
    @else
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-sand-200 text-left text-sm text-ocean-700">
                <thead class="bg-sand-50 text-ocean-900">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Reference</th>
                        <th class="px-4 py-3 font-semibold">Customer</th>
                        <th class="px-4 py-3 font-semibold">Package</th>
                        <th class="px-4 py-3 font-semibold">Travel date</th>
                        <th class="px-4 py-3 font-semibold">Qty</th>
                        <th class="px-4 py-3 font-semibold">Total</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand-200 bg-white">
                    @foreach($latestBookings as $booking)
                        @php $packageBooking = $booking->packageBookings->first(); @endphp
                        <tr>
                            <td class="px-4 py-4 font-semibold text-ocean-950">{{ $booking->booking_reference }}</td>
                            <td class="px-4 py-4">{{ $booking->user->name ?? 'Guest' }}<br><span class="text-xs text-ocean-500">{{ $booking->user->email ?? 'no email' }}</span></td>
                            <td class="px-4 py-4">
                                @if($packageBooking && $packageBooking->travelPackage)
                                    {{ $packageBooking->travelPackage->title }}
                                @else
                                    <span class="text-ocean-500">Package deleted</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">{{ optional($packageBooking)->travel_date?->format('M j, Y') ?? 'N/A' }}</td>
                            <td class="px-4 py-4">{{ optional($packageBooking)->number_of_travelers ?? 'N/A' }}</td>
                            <td class="px-4 py-4">${{ number_format($booking->total_price, 2) }}</td>
                            <td class="px-4 py-4 text-coral-600">{{ ucfirst($booking->booking_status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

