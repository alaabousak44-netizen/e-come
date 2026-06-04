@extends('layouts.member')

@section('title', 'Cart')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-ocean-950">Your cart</h1>
    <p class="mt-2 text-sm text-ocean-600">Review selected packages, update travel details, and complete checkout.</p>
</div>

@if (count($items) === 0)
<div class="rounded-3xl bg-white p-12 text-center shadow-md">
    <p class="text-xl font-semibold text-ocean-950">Your cart is empty</p>
    <p class="mt-3 text-sm text-ocean-600">Add a travel package to your cart before checking out.</p>
    <a href="{{ route('home') }}" class="mt-6 inline-flex rounded-full bg-ocean-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Browse packages</a>
</div>
@else
<div class="space-y-6">
    @foreach ($items as $item)
    <div class="rounded-3xl bg-white p-6 shadow-md">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="space-y-3">
                <h2 class="text-xl font-semibold text-ocean-950">{{ $item['package']->title }}</h2>
                <p class="text-sm text-ocean-600">{{ $item['package']->destination_city }}, {{ $item['package']->destination_country }}</p>
                <p class="text-sm text-ocean-600">Departure: {{ $item['travel_date'] }}</p>
                <form action="{{ route('cart.update', $item['package']) }}" method="POST" class="space-y-4 rounded-3xl border border-sand-200 bg-sand-50 p-4">
                    @csrf
                    <div>
                        <label for="travel_date_{{ $item['package']->package_id }}" class="block text-sm font-medium text-ocean-700">Departure date</label>
                        @php
                            $departureOptions = $item['package']->departureDates
                                ->filter(fn ($date) => $date->departure_date->gte(now()->startOfDay()))
                                ->sortBy('departure_date');
                        @endphp
                        @if ($departureOptions->isNotEmpty())
                            <select id="travel_date_{{ $item['package']->package_id }}" name="travel_date" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-white px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                                @foreach ($departureOptions as $option)
                                    <option value="{{ $option->departure_date->format('Y-m-d') }}" @selected(old('travel_date', $item['travel_date']) === $option->departure_date->format('Y-m-d'))>{{ $option->departure_date->format('F j, Y') }}</option>
                                @endforeach
                            </select>
                        @else
                            <input id="travel_date_{{ $item['package']->package_id }}" type="date" name="travel_date" value="{{ old('travel_date', $item['travel_date']) }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-white px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                        @endif
                    </div>
                    <div>
                        <label for="number_of_travelers_{{ $item['package']->package_id }}" class="block text-sm font-medium text-ocean-700">Travelers</label>
                        <input id="number_of_travelers_{{ $item['package']->package_id }}" type="number" name="number_of_travelers" value="{{ old('number_of_travelers', $item['number_of_travelers']) }}" min="1" max="{{ $item['package']->max_capacity ?: 20 }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-white px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                        <p class="mt-2 text-sm text-ocean-600">Maximum {{ $item['package']->max_capacity ?: 20 }} travelers per booking. If your group is larger, please wait for the next available date or contact support.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="rounded-full bg-ocean-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Update</button>
                    </div>
                </form>

                <div class="rounded-3xl border border-sand-200 bg-sand-50 p-4">
                    <p class="text-sm font-medium text-ocean-700">Action</p>
                    <p class="mt-2 text-sm text-ocean-600">Remove this package from your cart if you no longer want to book it.</p>
                    <form action="{{ route('cart.remove', $item['package']) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full rounded-full bg-white border border-sand-300 px-4 py-3 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="rounded-3xl bg-white p-8 shadow-md">
        <p class="text-sm uppercase tracking-widest text-ocean-600">Cart total</p>
        <div class="mt-3 flex items-center justify-between gap-4">
            <span class="text-lg font-semibold text-ocean-950">Total</span>
            <span class="text-3xl font-bold text-coral-500">${{ number_format($subtotal, 2) }}</span>
        </div>

        <form action="{{ route('cart.checkout') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="payment_method" class="block text-sm font-medium text-ocean-700">Payment method</label>
                <select id="payment_method" name="payment_method" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                    <option value="credit_card" @selected(old('payment_method') === 'credit_card')>Credit card</option>
                    <option value="debit_card" @selected(old('payment_method') === 'debit_card')>Debit card</option>
                    <option value="paypal" @selected(old('payment_method') === 'paypal')>PayPal</option>
                </select>
                @error('payment_method')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div id="card-fields" class="grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="cardholder_name" class="block text-sm font-medium text-ocean-700">Cardholder name</label>
                    <input id="cardholder_name" name="cardholder_name" type="text" value="{{ old('cardholder_name', auth()->user()->name) }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="Name on card">
                    @error('cardholder_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="card_number" class="block text-sm font-medium text-ocean-700">Card number</label>
                    <input id="card_number" name="card_number" type="text" value="{{ old('card_number') }}" maxlength="19" inputmode="numeric" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="4242 4242 4242 4242">
                    @error('card_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <p class="text-sm text-ocean-600">Demo payment — no real charge. Your booking will be saved immediately after you pay.</p>

            <button type="submit" class="mt-4 w-full rounded-full bg-coral-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-coral-600">Pay &amp; confirm booking</button>
        </form>
    </div>
</div>
@endif
@endsection
