<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CustomerProfile;
use App\Models\TravelPackage;
use App\Models\TravelPackageImage;
use App\Models\TravelRequest;
use App\Models\User;
use Illuminate\Support\Carbon;
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
        $totalRequests = TravelRequest::count();
        $latestBookings = Booking::with(['user', 'packageBookings.travelPackage', 'payments'])
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

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
            'totalRequests',
            'latestBookings',
            'ageGroups',
            'regionDistribution',
            'genderDistribution',
            'hasProfileTable'
        ));
    }

    public function packages(): View
    {
        $this->authorizeAdmin();

        $packages = TravelPackage::with('departureDates')->orderByDesc('created_at')->get();

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
            'departure_dates' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $package = TravelPackage::create([
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

        $package->syncDepartureDates($this->parseDepartureDates($request->input('departure_dates')));

        foreach ($request->file('images', []) as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $path = $file->store('packages', 'public');
            TravelPackageImage::create([
                'package_id' => $package->package_id,
                'path' => $path,
                'created_at' => now(),
            ]);
        }

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
            'departure_dates' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
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

        $package->syncDepartureDates($this->parseDepartureDates($request->input('departure_dates')));

        foreach ($request->file('images', []) as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $path = $file->store('packages', 'public');
            TravelPackageImage::create([
                'package_id' => $package->package_id,
                'path' => $path,
                'created_at' => now(),
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Destination updated successfully.');
    }

    private function parseDepartureDates(string $input): array
    {
        $lines = preg_split('/\r?\n/', trim($input));
        $dates = [];

        foreach ($lines as $line) {
            $value = trim($line);
            if ($value === '') {
                continue;
            }

            $carbon = Carbon::createFromFormat('Y-m-d', $value);
            if (! $carbon || $carbon->format('Y-m-d') !== $value) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'departure_dates' => 'Each departure date must be in YYYY-MM-DD format.',
                ]);
            }

            if ($carbon->lt(now()->startOfDay())) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'departure_dates' => 'Departure dates must be today or later.',
                ]);
            }

            $dates[] = $carbon->format('Y-m-d');
        }

        $dates = array_values(array_unique($dates));

        if (empty($dates)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'departure_dates' => 'Enter at least one valid departure date.',
            ]);
        }

        return $dates;
    }

    public function destroyPackage(TravelPackage $package): RedirectResponse
    {
        $this->authorizeAdmin();

        // delete related images from storage
        if ($package->images()->count() > 0) {
            foreach ($package->images as $img) {
                try {\Illuminate\Support\Facades\Storage::disk('public')->delete($img->path); } catch (\Throwable $e) {}
                $img->delete();
            }
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Destination deleted successfully.');
    }

    public function destroyPackageImage(TravelPackage $package, TravelPackageImage $image): RedirectResponse
    {
        $this->authorizeAdmin();

        if ($image->package_id !== $package->package_id) {
            abort(404);
        }

        try {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
        } catch (\Throwable $e) {}

        $image->delete();

        return redirect()->back()->with('success', 'Image removed.');
    }

    public function requests(): View
    {
        $this->authorizeAdmin();

        $requests = TravelRequest::orderByDesc('created_at')->get();

        return view('admin.requests.index', compact('requests'));
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
