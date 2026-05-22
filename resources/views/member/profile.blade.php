@extends('layouts.member')

@section('title', 'Profile')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-ocean-950">Your profile</h1>
    <p class="mt-2 text-ocean-600">Manage your account and travel details.</p>
</div>

<form action="{{ route('profile.update') }}" method="POST" class="max-w-2xl rounded-3xl bg-white p-8 shadow-md">
    @csrf
    @method('PUT')

    <h2 class="text-lg font-semibold text-ocean-950">Account</h2>
    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="first_name" class="block text-sm font-medium text-ocean-700">First name</label>
            <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('first_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="last_name" class="block text-sm font-medium text-ocean-700">Last name</label>
            <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('last_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label for="email" class="block text-sm font-medium text-ocean-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label for="phone" class="block text-sm font-medium text-ocean-700">Phone</label>
            <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
        </div>
    </div>

    <h2 class="mt-10 text-lg font-semibold text-ocean-950">Travel details</h2>
    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="nationality" class="block text-sm font-medium text-ocean-700">Nationality</label>
            <input id="nationality" name="nationality" type="text" value="{{ old('nationality', $user->profile?->nationality) }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
        </div>
        <div>
            <label for="date_of_birth" class="block text-sm font-medium text-ocean-700">Date of birth</label>
            <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $user->profile?->date_of_birth?->format('Y-m-d')) }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
        </div>
        <div class="sm:col-span-2">
            <label for="passport_number" class="block text-sm font-medium text-ocean-700">Passport number</label>
            <input id="passport_number" name="passport_number" type="text" value="{{ old('passport_number', $user->profile?->passport_number) }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
        </div>
    </div>

    <button type="submit" class="mt-8 w-full rounded-2xl bg-ocean-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800 sm:w-auto">Save changes</button>
</form>
@endsection
