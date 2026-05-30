@extends('layouts.member')

@section('title', 'Edit destination')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-ocean-950">Edit destination</h1>
    <p class="mt-2 text-ocean-600">Update the details for this travel package.</p>
</div>

<form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data" class="space-y-8 rounded-3xl bg-white p-8 shadow-sm border border-sand-200">
    @csrf
    @method('PUT')

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="title" class="block text-sm font-medium text-ocean-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $package->title) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="destination_city" class="block text-sm font-medium text-ocean-700">City</label>
            <input id="destination_city" name="destination_city" type="text" value="{{ old('destination_city', $package->destination_city) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('destination_city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="destination_country" class="block text-sm font-medium text-ocean-700">Country</label>
            <input id="destination_country" name="destination_country" type="text" value="{{ old('destination_country', $package->destination_country) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('destination_country')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="duration_days" class="block text-sm font-medium text-ocean-700">Duration (days)</label>
            <input id="duration_days" name="duration_days" type="number" min="1" value="{{ old('duration_days', $package->duration_days) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('duration_days')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="price_per_person" class="block text-sm font-medium text-ocean-700">Price per person</label>
            <input id="price_per_person" name="price_per_person" type="number" step="0.01" min="0" value="{{ old('price_per_person', $package->price_per_person) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('price_per_person')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="max_capacity" class="block text-sm font-medium text-ocean-700">Max capacity</label>
            <input id="max_capacity" name="max_capacity" type="number" min="1" value="{{ old('max_capacity', $package->max_capacity) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
            @error('max_capacity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-ocean-700">Description</label>
        <textarea id="description" name="description" rows="6" required class="mt-2 w-full rounded-3xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">{{ old('description', $package->description) }}</textarea>
        @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="images" class="block text-sm font-medium text-ocean-700">Add photos</label>
        <input id="images" name="images[]" type="file" multiple accept="image/*" class="mt-2 w-full text-sm" />
        @error('images')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <label class="inline-flex items-center gap-3 text-sm font-medium text-ocean-700">
            <input type="hidden" name="is_active" value="0">
            <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $package->is_active)) class="h-4 w-4 rounded border-sand-300 text-ocean-700 focus:ring-ocean-500">
            Active package
        </label>
        <button type="submit" class="rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Update destination</button>
    </div>
</form>

@if($package->images && $package->images->count() > 0)
    <div class="mt-8">
        <label class="block text-sm font-medium text-ocean-700">Existing photos</label>
        <div class="mt-2 flex flex-wrap gap-3">
            @foreach($package->images as $img)
                <div class="relative w-32 rounded-md overflow-hidden border border-sand-200 bg-sand-50">
                    <img src="{{ asset('storage/' . $img->path) }}" alt="photo" class="h-20 w-32 object-cover">
                    <form action="{{ route('admin.packages.images.destroy', [$package, $img]) }}" method="POST" class="absolute right-1 top-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full bg-red-50 p-1 text-red-700">&times;</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
