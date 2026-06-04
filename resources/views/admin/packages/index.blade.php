@extends('layouts.member')

@section('title', 'Destination management')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-bold text-ocean-950">Destination management</h1>
        <p class="mt-2 text-ocean-600">Edit or remove travel packages, and add new destinations.</p>
    </div>
    <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center justify-center rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Add destination</a>
</div>

<div class="overflow-hidden rounded-3xl border border-sand-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-sand-200 text-left text-sm text-ocean-700">
        <thead class="bg-sand-50 text-xs uppercase tracking-widest text-ocean-600">
            <tr>
                <th class="px-6 py-4">Title</th>
                <th class="px-6 py-4">Destination</th>
                <th class="px-6 py-4">Departure</th>
                <th class="px-6 py-4">Price</th>
                <th class="px-6 py-4">Duration</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-sand-200 bg-white">
            @forelse($packages as $package)
                <tr>
                    <td class="px-6 py-4 font-semibold text-ocean-950">{{ $package->title }}</td>
                    <td class="px-6 py-4">{{ $package->destination_city }}, {{ $package->destination_country }}</td>
                    <td class="px-6 py-4">{{ optional($package->next_departure_date)->format('M j, Y') ?? 'No available date' }}</td>
                    <td class="px-6 py-4">${{ number_format($package->price_per_person, 2) }}</td>
                    <td class="px-6 py-4">{{ $package->duration_days }} days</td>
                    <td class="px-6 py-4">{{ $package->is_active ? 'Active' : 'Inactive' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.packages.edit', $package) }}" class="rounded-full bg-sand-100 px-4 py-2 text-xs font-semibold text-ocean-900 transition hover:bg-sand-200">Edit</a>
                            <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Delete this destination?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full bg-red-50 px-4 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-10 text-center text-sm text-ocean-600" colspan="6">No destinations found. Add one to get started.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
