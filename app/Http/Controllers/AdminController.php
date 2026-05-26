<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CustomerProfile;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    private function authorizeAdmin(): void
    {
        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }
    }

    public function index(): View
    {
        $this->authorizeAdmin();

        $totalUsers = User::count();
        $totalPackages = TravelPackage::count();
        $totalBookings = Booking::count();

        $ageGroups = [
            'Under 18' => 0,
            '18-25' => 0,
            '26-35' => 0,
            '36-50' => 0,
            '51+' => 0,
        ];

        $regionDistribution = [];
        $genderDistribution = [];
        $hasProfileTable = Schema::hasTable('customer_profiles');

        if ($hasProfileTable) {
            $profiles = CustomerProfile::all();

            foreach ($profiles as $profile) {
                if ($profile->date_of_birth) {
                    $age = now()->diffInYears($profile->date_of_birth);

                    if ($age < 18) {
                        $ageGroups['Under 18']++;
                    } elseif ($age <= 25) {
                        $ageGroups['18-25']++;
                    } elseif ($age <= 35) {
                        $ageGroups['26-35']++;
                    } elseif ($age <= 50) {
                        $ageGroups['36-50']++;
                    } else {
                        $ageGroups['51+']++;
                    }
                }

                $region = $profile->nationality ?: 'Unknown';
                $regionDistribution[$region] = ($regionDistribution[$region] ?? 0) + 1;

                $gender = $profile->gender ?? 'Unknown';
                $genderDistribution[$gender] = ($genderDistribution[$gender] ?? 0) + 1;
            }
        }

        arsort($regionDistribution);
        arsort($genderDistribution);

        return view('admin.index', compact(
            'totalUsers',
            'totalPackages',
            'totalBookings',
            'ageGroups',
            'regionDistribution',
            'genderDistribution',
            'hasProfileTable'
        ));
    }

    public function packages(): View
    {
        $this->authorizeAdmin();

        $packages = TravelPackage::orderByDesc('created_at')->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function createPackage(): View
    {
        $this->authorizeAdmin();

        return view('admin.packages.create', [
            'package' => new TravelPackage(),
        ]);
    }

    public function storePackage(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'destination_city' => ['required', 'string', 'max:100'],
            'destination_country' => ['required', 'string', 'max:100'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'price_per_person' => ['required', 'numeric', 'min:0'],
            'max_capacity' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        TravelPackage::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'destination_city' => $validated['destination_city'],
            'destination_country' => $validated['destination_country'],
            'duration_days' => $validated['duration_days'],
            'price_per_person' => $validated['price_per_person'],
            'max_capacity' => $validated['max_capacity'],
            'is_active' => $request->boolean('is_active'),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Destination added successfully.');
    }

    public function editPackage(TravelPackage $package): View
    {
        $this->authorizeAdmin();

        return view('admin.packages.edit', compact('package'));
    }

    public function updatePackage(Request $request, TravelPackage $package): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'destination_city' => ['required', 'string', 'max:100'],
            'destination_country' => ['required', 'string', 'max:100'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'price_per_person' => ['required', 'numeric', 'min:0'],
            'max_capacity' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $package->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'destination_city' => $validated['destination_city'],
            'destination_country' => $validated['destination_country'],
            'duration_days' => $validated['duration_days'],
            'price_per_person' => $validated['price_per_person'],
            'max_capacity' => $validated['max_capacity'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Destination updated successfully.');
    }

    public function destroyPackage(TravelPackage $package): RedirectResponse
    {
        $this->authorizeAdmin();

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Destination deleted successfully.');
    }

    public function users(): View
    {
        $this->authorizeAdmin();

        $users = User::with('profile')->orderByDesc('created_at')->get();

        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user): View
    {
        $this->authorizeAdmin();

        $user->load(['profile', 'bookings.packageBookings.travelPackage']);

        return view('admin.users.show', compact('user'));
    }
}
