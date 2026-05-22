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
            <a href="{{ route('home') }}" class="text-sm font-semibold uppercase tracking-widest text-ocean-500 hover:text-ocean-700">Back to home</a>
            <h1 class="mt-4 text-4xl font-bold text-ocean-950 sm:text-5xl">Customer Login & Sign Up</h1>
            <p class="mt-4 mx-auto max-w-2xl text-base text-ocean-700">Access your account or create a new profile to book trips, track reservations, and manage your travel plans.</p>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <section class="rounded-3xl border border-sand-300 bg-white p-8 shadow-lg shadow-ocean-950/5">
                <h2 class="text-2xl font-semibold text-ocean-950">Customer Login</h2>
                <p class="mt-2 text-sm text-ocean-600">Enter your email and password to continue.</p>
                <form action="{{ route('login.submit') }}" method="POST" class="mt-8 space-y-6">
                    @csrf
                    <div>
                        <label for="login-email" class="block text-sm font-medium text-ocean-700">Email</label>
                        <input id="login-email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="you@example.com">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="login-password" class="block text-sm font-medium text-ocean-700">Password</label>
                        <input id="login-password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="••••••••">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-ocean-600">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="rounded border-sand-300 text-ocean-700 focus:ring-ocean-500">
                        Remember me
                    </label>
                    <button type="submit" class="w-full rounded-2xl bg-ocean-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-ocean-800">Login</button>
                </form>
            </section>

            <section class="rounded-3xl border border-sand-300 bg-white p-8 shadow-lg shadow-ocean-950/5">
                <h2 class="text-2xl font-semibold text-ocean-950">Sign Up</h2>
                <p class="mt-2 text-sm text-ocean-600">Create your customer account and start searching trips today.</p>
                <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
                    @csrf
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="signup-first-name" class="block text-sm font-medium text-ocean-700">First name</label>
                            <input id="signup-first-name" name="first_name" type="text" value="{{ old('first_name') }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                            @error('first_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="signup-last-name" class="block text-sm font-medium text-ocean-700">Last name</label>
                            <input id="signup-last-name" name="last_name" type="text" value="{{ old('last_name') }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                            @error('last_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="signup-email" class="block text-sm font-medium text-ocean-700">Email</label>
                        <input id="signup-email" name="email" type="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="you@example.com">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="signup-phone" class="block text-sm font-medium text-ocean-700">Phone (optional)</label>
                        <input id="signup-phone" name="phone" type="text" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="+1 555 000 0000">
                    </div>
                    <div>
                        <label for="signup-password" class="block text-sm font-medium text-ocean-700">Password</label>
                        <input id="signup-password" name="password" type="password" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20" placeholder="At least 8 characters">
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="signup-password-confirm" class="block text-sm font-medium text-ocean-700">Confirm password</label>
                        <input id="signup-password-confirm" name="password_confirmation" type="password" required class="mt-2 w-full rounded-2xl border border-sand-300 bg-sand-100 px-4 py-3 text-sm text-ocean-950 focus:border-ocean-500 focus:outline-none focus:ring-2 focus:ring-ocean-500/20">
                    </div>
                    <button type="submit" class="w-full rounded-2xl bg-coral-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-coral-600">Create account</button>
                </form>
            </section>
        </div>
    </div>
</body>
</html>
