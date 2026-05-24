<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Sent | Horizon Voyages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sand-100 text-ocean-950">
    <main class="mx-auto flex min-h-screen max-w-3xl items-center px-4 py-16 sm:px-6 lg:px-8">
        <div class="w-full rounded-[2rem] bg-white p-8 shadow-2xl shadow-ocean-950/10 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-coral-500">Request received</p>
            <h1 class="mt-4 font-display text-3xl font-bold text-ocean-950 sm:text-4xl">Your travel request has been sent.</h1>
            <p class="mt-4 text-base leading-7 text-ocean-700">
                Thank you for reaching out. Our travel team will review your request and get back to you soon.
            </p>

            <div class="mt-8 rounded-2xl bg-ocean-50 px-5 py-4 text-sm text-ocean-800">
                <p class="font-semibold">Request reference</p>
                <p class="mt-1 text-lg font-bold text-ocean-950">#{{ session('request_reference', 'pending') }}</p>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home') }}" class="rounded-full bg-ocean-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Back to home</a>
                <a href="{{ route('search') }}" class="rounded-full border border-ocean-200 px-5 py-3 text-sm font-semibold text-ocean-950 transition hover:bg-sand-100">Browse trips</a>
            </div>
        </div>
    </main>
</body>
</html>
