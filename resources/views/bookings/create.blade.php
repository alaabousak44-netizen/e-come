@extends('layouts.member')

@section('title', 'Book Trip')

@section('content')
<div class="mb-8">
    <a href="{{ route('search', request()->only(['destination', 'dates', 'travelers'])) }}" class="text-sm font-semibold text-ocean-600 hover:text-ocean-800">&larr; Back to results</a>
    <h1 class="mt-4 text-3xl font-bold text-ocean-950">Book &amp; pay</h1>
    <p class="mt-2 text-ocean-600">Review your trip and complete payment to confirm your reservation.</p>
</div>

<div class="grid gap-8 lg:grid-cols-5">
    <div class="lg:col-span-2">
        <div class="rounded-3xl bg-white p-8 shadow-md">
            <p class="text-xs uppercase tracking-widest text-ocean-500">Trip package</p>
            <h2 class="mt-2 text-2xl font-semibold text-ocean-950">{{ $package->title }}</h2>
            <p class="mt-2 text-sm text-ocean-600">{{ $package->destination_city }}, {{ $package->destination_country }}</p>
            <p class="mt-4 text-sm text-ocean-700">{{ $package->description }}</p>
            <dl class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between border-b border-sand-200 pb-2">
                    <dt class="text-ocean-600">Duration</dt>
                    <dd class="font-semibold text-ocean-950">{{ $package->duration_days }} days</dd>
                </div>
                <div class="flex justify-between border-b border-sand-200 pb-2">
                    <dt class="text-ocean-600">Price per person</dt>
                    <dd class="font-semibold text-ocean-950">${{ number_format($package->price_per_person, 2) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-ocean-600">Max travelers</dt>
                    <dd class="font-semibold text-ocean-950">{{ $package->max_capacity }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="lg:col-span-3">
        <form action="{{ route('bookings.store', $package) }}" method="POST" class="rounded-3xl bg-white p-8 shadow-md" id="booking-form">
            @csrf

            <h2 class="text-lg font-semibold text-ocean-950">Trip details</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="travel_date" class="block text-sm font-medium text-ocean-700">Travel date</label>
                    <input type="date" id="travel_date" name="travel_date" value="{{ old('travel_date', $defaultDate) }}" min="{{ now()->addDay()->format('Y-m-d') }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                    @error('travel_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="number_of_travelers" class="block text-sm font-medium text-ocean-700">Number of travelers</label>
                    <input type="number" id="number_of_travelers" name="number_of_travelers" value="{{ old('number_of_travelers', $defaultTravelers) }}" min="1" max="{{ $package->max_capacity }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                    @error('number_of_travelers')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <p class="mt-4 rounded-2xl bg-ocean-50 px-4 py-3 text-sm text-ocean-800">
                Estimated total: <strong id="total-display">${{ number_format($package->price_per_person * $defaultTravelers, 2) }}</strong>
            </p>

            <h2 class="mt-10 text-lg font-semibold text-ocean-950">Payment</h2>
            <div class="mt-6">
                <label for="payment_method" class="block text-sm font-medium text-ocean-700">Payment method</label>
                <select id="payment_method" name="payment_method" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                    <option value="credit_card" @selected(old('payment_method') === 'credit_card')>Credit card</option>
                    <option value="debit_card" @selected(old('payment_method') === 'debit_card')>Debit card</option>
                    <option value="paypal" @selected(old('payment_method') === 'paypal')>PayPal</option>
                </select>
                @error('payment_method')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div id="card-fields" class="mt-6 grid gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="cardholder_name" class="block text-sm font-medium text-ocean-700">Cardholder name</label>
                    <input type="text" id="cardholder_name" name="cardholder_name" value="{{ old('cardholder_name', auth()->user()->name) }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="Name on card">
                    @error('cardholder_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="card_number" class="block text-sm font-medium text-ocean-700">Card number</label>
                    <input type="text" id="card_number" name="card_number" value="{{ old('card_number') }}" inputmode="numeric" maxlength="19" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="4242 4242 4242 4242">
                    @error('card_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <p class="mt-4 text-xs text-ocean-500">Demo payment — no real charge. Your booking will be saved immediately after you pay.</p>

            <button type="submit" class="mt-8 w-full rounded-2xl bg-coral-500 px-6 py-4 text-sm font-semibold text-white transition hover:bg-coral-600 sm:w-auto">
                Pay &amp; confirm booking
            </button>
        </form>
    </div>
</div>

<script>
    const pricePerPerson = {{ $package->price_per_person }};
    const travelersInput = document.getElementById('number_of_travelers');
    const totalDisplay = document.getElementById('total-display');
    const paymentMethod = document.getElementById('payment_method');
    const cardFields = document.getElementById('card-fields');

    function updateTotal() {
        const travelers = parseInt(travelersInput.value, 10) || 1;
        const total = (pricePerPerson * travelers).toFixed(2);
        totalDisplay.textContent = '$' + Number(total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function toggleCardFields() {
        const isCard = paymentMethod.value === 'credit_card' || paymentMethod.value === 'debit_card';
        cardFields.style.display = isCard ? 'grid' : 'none';
        document.getElementById('cardholder_name').required = isCard;
        document.getElementById('card_number').required = isCard;
    }

    travelersInput.addEventListener('input', updateTotal);
    paymentMethod.addEventListener('change', toggleCardFields);
    toggleCardFields();
</script>
@endsection
