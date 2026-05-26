@extends('layouts.member')

@section('title', 'Users')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-ocean-950">Users</h1>
    <p class="mt-2 text-ocean-600">Review registered user accounts and profile details.</p>
</div>

<div class="overflow-hidden rounded-3xl border border-sand-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-sand-200 text-left text-sm text-ocean-700">
        <thead class="bg-sand-50 text-xs uppercase tracking-widest text-ocean-600">
            <tr>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Nationality</th>
                <th class="px-6 py-4">Age</th>
                <th class="px-6 py-4">Sex</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-sand-200 bg-white">
            @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 font-semibold text-ocean-950">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->profile?->nationality ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @if($user->profile?->date_of_birth)
                            {{ $user->profile->date_of_birth->age }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $user->profile?->gender ?? 'Unknown' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.users.show', $user) }}" class="rounded-full bg-sand-100 px-4 py-2 text-xs font-semibold text-ocean-900 transition hover:bg-sand-200">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-10 text-center text-sm text-ocean-600" colspan="6">No users were found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
