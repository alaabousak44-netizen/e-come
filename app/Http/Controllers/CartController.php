<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PackageBooking;
use App\Models\Payment;
use App\Models\TravelPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = $this->cartItems($request);
        $subtotal = array_reduce($cartItems, fn ($sum, $item) => $sum + $item['item_total'], 0);

        return view('cart.index', [
            'items' => $cartItems,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request, TravelPackage $package): RedirectResponse
    {
        if (! $package->is_active || ! $package->next_departure_date) {
            abort(404);
        }

        $package->load('departureDates');

        $availableDates = $package->departureDates
            ->filter(fn ($date) => $date->departure_date->gte(now()->startOfDay()))
            ->pluck('departure_date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->all();

        if (empty($availableDates)) {
            abort(404);
        }

        $selectedDate = $request->query('dates', $package->next_departure_date->format('Y-m-d'));
        if (! in_array($selectedDate, $availableDates, true)) {
            $selectedDate = $package->next_departure_date->format('Y-m-d');
        }

        $cart = $request->session()->get('cart', []);
        $packageId = (string) $package->package_id;

        $cart[$packageId] = array_merge($cart[$packageId] ?? [], [
            'package_id' => $package->package_id,
            'travel_date' => $selectedDate,
            'number_of_travelers' => max(1, (int) $request->query('travelers', 1)),
        ]);

        $request->session()->put('cart', $cart);
        $request->session()->flash('success', 'Added "'.$package->title.'" to your cart.');

        return redirect()->back();
    }

    public function update(Request $request, TravelPackage $package): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $packageId = (string) $package->package_id;

        if (! isset($cart[$packageId])) {
            return redirect()->route('cart.index')->with('success', 'The requested package is not in your cart.');
        }

        $package->load('departureDates');

        $availableDates = $package->departureDates
            ->filter(fn ($date) => $date->departure_date->gte(now()->startOfDay()))
            ->pluck('departure_date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->all();

        $rules = [
            'travel_date' => ['required', 'date', Rule::in($availableDates)],
            'number_of_travelers' => ['required', 'integer', 'min:1', 'max:'.($package->max_capacity ?: 20)],
        ];

        $validated = $request->validate($rules, [
            'travel_date.in' => 'Please use a valid package departure date.',
            'number_of_travelers.max' => 'Out of stock for that many travelers. Please wait for the next available date or contact us for group bookings.',
        ]);

        $cart[$packageId]['travel_date'] = $validated['travel_date'];
        $cart[$packageId]['number_of_travelers'] = $validated['number_of_travelers'];

        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart item updated.');
    }

    public function remove(Request $request, TravelPackage $package): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $packageId = (string) $package->package_id;

        if (isset($cart[$packageId])) {
            unset($cart[$packageId]);
            $request->session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Removed package from your cart.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $cartItems = $this->cartItems($request);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        if ($request->filled('card_number')) {
            $request->merge([
                'card_number' => preg_replace('/\D/', '', $request->input('card_number')),
            ]);
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:credit_card,debit_card,paypal'],
            'cardholder_name' => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'string', 'max:100'],
            'card_number' => ['required_if:payment_method,credit_card,debit_card', 'nullable', 'string', 'min:13', 'max:19'],
        ]);

        $totalPrice = array_reduce($cartItems, fn ($sum, $item) => $sum + $item['item_total'], 0);

        $booking = DB::transaction(function () use ($validated, $cartItems, $totalPrice) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'booking_reference' => $this->generateBookingReference(),
                'total_price' => round($totalPrice, 2),
                'booking_status' => 'confirmed',
                'created_at' => now(),
            ]);

            foreach ($cartItems as $item) {
                PackageBooking::create([
                    'booking_id' => $booking->booking_id,
                    'package_id' => $item['package']->package_id,
                    'travel_date' => $item['travel_date'],
                    'number_of_travelers' => $item['number_of_travelers'],
                ]);
            }

            Payment::create([
                'booking_id' => $booking->booking_id,
                'transaction_reference' => $this->generateTransactionReference(),
                'amount' => round($totalPrice, 2),
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            return $booking;
        });

        $request->session()->forget('cart');

        return redirect()->route('bookings.confirmation', $booking);
    }

    private function cartItems(Request $request): array
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return [];
        }

        $packageIds = array_keys($cart);
        $packages = TravelPackage::with('departureDates')->whereIn('package_id', $packageIds)->active()->get()->keyBy('package_id');

        return collect($cart)
            ->map(function ($item) use ($packages) {
                $package = $packages[$item['package_id']] ?? null;

                if (! $package) {
                    return null;
                }

                $validDates = $package->departureDates
                    ->pluck('departure_date')
                    ->map(fn ($date) => $date->format('Y-m-d'));

                if (! $validDates->contains($item['travel_date'])) {
                    return null;
                }

                return [
                    'package' => $package,
                    'travel_date' => $item['travel_date'],
                    'number_of_travelers' => $item['number_of_travelers'],
                    'item_total' => round($package->price_per_person * $item['number_of_travelers'], 2),
                ];
            })
            ->filter()
            ->values()
            ->all();
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
