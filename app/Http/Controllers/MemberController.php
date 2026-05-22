<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function welcome(): View
    {
        return view('member.welcome', ['user' => Auth::user()]);
    }

    public function dashboard(): View
    {
        $user = Auth::user()->load(['bookings.packageBookings.travelPackage', 'profile']);

        $bookings = $user->bookings()
            ->with(['packageBookings.travelPackage', 'payments'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('member.dashboard', [
            'user' => $user,
            'bookings' => $bookings,
            'bookingCount' => $user->bookings()->count(),
        ]);
    }

    public function bookings(): View
    {
        $bookings = Auth::user()
            ->bookings()
            ->with(['packageBookings.travelPackage', 'payments'])
            ->orderByDesc('created_at')
            ->get();

        return view('member.bookings', [
            'user' => Auth::user(),
            'bookings' => $bookings,
        ]);
    }

    public function profile(): View
    {
        $user = Auth::user()->load('profile');

        return view('member.profile', ['user' => $user]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,'.$user->user_id.',user_id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'nationality' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'passport_number' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->user_id],
            [
                'nationality' => $validated['nationality'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'passport_number' => $validated['passport_number'] ?? null,
            ]
        );

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
