@extends('layouts.member')

@section('title', 'User details')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-bold text-ocean-950">{{ $user->name }}</h1>
        <p class="mt-2 text-ocean-600">Details for this registered user.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-full bg-sand-100 px-6 py-3 text-sm font-semibold text-ocean-900 transition hover:bg-sand-200">Back to users</a>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <section class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Account</h2>
        <div class="mt-6 space-y-4 text-sm text-ocean-700">
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Email</p>
                <p class="mt-2">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Phone</p>
                <p class="mt-2">{{ $user->phone ?? 'Not set' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Nationality</p>
                <p class="mt-2">{{ $user->profile?->nationality ?? 'Not set' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Sex</p>
                <p class="mt-2">{{ $user->profile?->gender ?? 'Unknown' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Date of birth</p>
                <p class="mt-2">{{ $user->profile?->date_of_birth?->format('F j, Y') ?? 'Not set' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-ocean-500">Age</p>
                <p class="mt-2">{{ $user->profile?->date_of_birth ? $user->profile->date_of_birth->age : 'Unknown' }}</p>
            </div>
        </div>
    </section>

    <section class="rounded-3xl bg-white p-6 shadow-sm border border-sand-200">
        <h2 class="text-lg font-semibold text-ocean-950">Bookings</h2>
        @if($user->bookings->isEmpty())
            <p class="mt-6 text-sm text-ocean-600">This user has not made any bookings yet.</p>
        @else
            <div class="mt-6 space-y-4 text-sm text-ocean-700">
                @foreach($user->bookings as $booking)
                    <div class="rounded-3xl bg-sand-50 p-4">
                        <p class="font-semibold text-ocean-950">Booking #{{ $booking->booking_id }}</p>
                        <p class="mt-1 text-xs uppercase tracking-widest text-ocean-500">Status</p>
                        <p class="text-sm">{{ $booking->booking_status ?? 'Pending' }}</p>
                        <p class="mt-3 text-xs uppercase tracking-widest text-ocean-500">Total</p>
                        <p class="text-sm">${{ number_format($booking->total_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
