<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PackageBooking;
use App\Models\Payment;
use App\Models\TravelPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request, TravelPackage $package): View|RedirectResponse
    {
        if (! $package->is_active) {
            abort(404);
        }

        return view('bookings.create', [
            'package' => $package,
            'defaultTravelers' => $this->parseTravelersCount($request->query('travelers', '1')),
            'defaultDate' => $request->query('dates'),
        ]);
    }

    public function store(Request $request, TravelPackage $package): RedirectResponse
    {
        if (! $package->is_active) {
            abort(404);
        }

        $maxTravelers = $package->max_capacity ?: 20;

        if ($request->filled('card_number')) {
            $request->merge([
                'card_number' => preg_replace('/\D/', '', $request->input('card_number')),
            ]);
        }

        $validated = $request->validate([
            'travel_date' => ['required', 'date', 'after:today'],
            'number_of_travelers' => ['required', 'integer', 'min:1', 'max:'.$maxTravelers],
            'payment_method' => ['required', 'in:credit_card,debit_card,paypal'],
            'cardholder_name' => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'string', 'max:100'],
            'card_number' => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'string', 'min:13', 'max:19'],
        ]);

        $travelers = (int) $validated['number_of_travelers'];
        $totalPrice = round($package->price_per_person * $travelers, 2);

        $booking = DB::transaction(function () use ($package, $validated, $travelers, $totalPrice) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'booking_reference' => $this->generateBookingReference(),
                'total_price' => $totalPrice,
                'booking_status' => 'confirmed',
                'created_at' => now(),
            ]);

            PackageBooking::create([
                'booking_id' => $booking->booking_id,
                'package_id' => $package->package_id,
                'travel_date' => $validated['travel_date'],
                'number_of_travelers' => $travelers,
            ]);

            Payment::create([
                'booking_id' => $booking->booking_id,
                'transaction_reference' => $this->generateTransactionReference(),
                'amount' => $totalPrice,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            return $booking;
        });

        return redirect()->route('bookings.confirmation', $booking);
    }

    public function confirmation(Booking $booking): View
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['packageBookings.travelPackage', 'payments']);

        return view('bookings.confirmation', compact('booking'));
    }

    private function parseTravelersCount(string $value): int
    {
        return preg_match('/(\d+)/', $value, $matches) ? max(1, (int) $matches[1]) : 1;
    }

    private function generateBookingReference(): string
    {
        do {
            $reference = 'HV'.strtoupper(Str::random(10));
        } while (Booking::where('booking_reference', $reference)->exists());

        return substr($reference, 0, 12);
    }

    private function generateTransactionReference(): string
    {
        do {
            $reference = 'TXN'.strtoupper(Str::random(12));
        } while (Payment::where('transaction_reference', $reference)->exists());

        return substr($reference, 0, 20);
    }
}
