<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up | Horizon Voyages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-sand-100 text-ocean-950">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col justify-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <a href="{{ url('/') }}" class="text-sm font-semibold uppercase tracking-widest text-ocean-500 hover:text-ocean-700">Back to home</a>
            <h1 class="mt-4 text-4xl font-bold text-ocean-950 sm:text-5xl">Customer Login & Sign Up</h1>
            <p class="mt-4 max-w-2xl mx-auto text-base text-ocean-700">Access your account or create a new profile to book trips, track reservations, and manage your travel plans.</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <section class="rounded-3xl border border-sand-300 bg-white p-8 shadow-lg shadow-ocean-950/5">
                <h2 class="text-2xl font-semibold text-ocean-950">Customer Login</h2>
                <p class="mt-2 text-sm text-ocean-600">Enter your email and password to continue.</p>
                <form action="#" method="POST" class="mt-8 space-y-6">
                    <div>
                        <label for="login-email" class="block text-sm font-medium text-ocean-700">Email</label>
                        <input id="login-email" name="email" type="email" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="login-password" class="block text-sm font-medium text-ocean-700">Password</label>
                        <input id="login-password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="••••••••">
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-ocean-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Login</button>
                    <p class="text-center text-sm text-ocean-600">Forgot your password? <a href="#" class="font-semibold text-coral-500 hover:text-coral-600">Reset it here</a>.</p>
                </form>
            </section>

            <section class="rounded-3xl border border-sand-300 bg-white p-8 shadow-lg shadow-ocean-950/5">
                <h2 class="text-2xl font-semibold text-ocean-950">Sign Up</h2>
                <p class="mt-2 text-sm text-ocean-600">Create your customer account and start searching trips today.</p>
                <form action="#" method="POST" class="mt-8 space-y-6">
                    <div>
                        <label for="signup-name" class="block text-sm font-medium text-ocean-700">Full name</label>
                        <input id="signup-name" name="name" type="text" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="Your name">
                    </div>
                    <div>
                        <label for="signup-email" class="block text-sm font-medium text-ocean-700">Email</label>
                        <input id="signup-email" name="email" type="email" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="signup-password" class="block text-sm font-medium text-ocean-700">Password</label>
                        <input id="signup-password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="Create a password">
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-coral-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-coral-600">Create account</button>
                </form>
            </section>
        </div>
    </div>
</body>
</html>
