@extends('layouts.member')

@section('title', 'Travel requests')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-3xl font-bold text-ocean-950">Travel requests</h1>
        <p class="mt-2 text-ocean-600">Review the messages users submitted from the travel request form.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-sand-100 px-4 py-2 text-sm font-semibold text-ocean-700 transition hover:bg-sand-200">Back to dashboard</a>
</div>

<div class="overflow-hidden rounded-3xl border border-sand-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-sand-200 text-left text-sm text-ocean-700">
        <thead class="bg-sand-50 text-xs uppercase tracking-widest text-ocean-600">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Destination interest</th>
                <th class="px-6 py-4">Message</th>
                <th class="px-6 py-4">Submitted</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-sand-200 bg-white">
            @forelse($requests as $request)
                <tr class="hover:bg-sand-50">
                    <td class="whitespace-nowrap px-6 py-4 font-semibold text-ocean-950">{{ $request->name }}</td>
                    <td class="px-6 py-4 text-ocean-700">{{ $request->email }}</td>
                    <td class="px-6 py-4 text-ocean-700">{{ $request->destination_interest }}</td>
                    <td class="px-6 py-4 text-ocean-700 max-w-xl break-words">{{ $request->message }}</td>
                    <td class="px-6 py-4 text-ocean-500">{{ $request->created_at ? $request->created_at->format('M d, Y H:i') : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-10 text-center text-sm text-ocean-600" colspan="5">No travel requests have been submitted yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
