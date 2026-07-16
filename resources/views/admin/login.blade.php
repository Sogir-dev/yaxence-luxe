<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Access — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-neutral-100 antialiased font-sans">
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
        <div class="relative hidden flex-col justify-between overflow-hidden bg-gradient-to-br from-neutral-950 via-black to-neutral-900 p-12 lg:flex">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-24 top-1/4 h-[28rem] w-[28rem] rounded-full bg-gold-500/10 blur-3xl"></div>
                <div class="absolute -right-24 bottom-0 h-[24rem] w-[24rem] rounded-full bg-gold-500/10 blur-3xl"></div>
            </div>

            <a href="{{ route('home') }}" class="relative font-serif text-2xl tracking-[0.2em] text-gold-200">
                YAXENCE <span class="text-white">LUXE</span>
            </a>

            <div class="relative">
                <x-rotating-badge />
            </div>

            <div class="relative">
                <p class="font-serif text-2xl italic leading-relaxed text-neutral-200">
                    &ldquo;Behind every collection, a quiet room where it all comes together.&rdquo;
                </p>
                <p class="mt-4 text-xs uppercase tracking-[0.3em] text-neutral-500">Private Admin Console</p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center px-6 py-12 sm:px-10">
            <a href="{{ route('home') }}" class="mb-10 font-serif text-xl tracking-[0.2em] text-gold-200 lg:hidden">
                YAXENCE <span class="text-white">LUXE</span>
            </a>

            <div class="w-full max-w-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Restricted Access</p>
                <h1 class="mt-3 font-serif text-3xl text-white">Admin Sign In</h1>
                <p class="mt-2 text-sm text-neutral-500">Manage products, orders, and the storefront.</p>

                @if($errors->any())
                    <div class="mt-6 rounded-sm border border-red-800 bg-red-950/50 px-4 py-3 text-sm text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
                    </div>

                    <label class="flex items-center gap-2 text-sm text-neutral-400">
                        <input type="checkbox" name="remember" class="rounded-sm border-neutral-700 bg-neutral-900">
                        Keep me signed in
                    </label>

                    <button type="submit" class="w-full rounded-sm bg-gold-400 px-6 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black transition hover:bg-gold-300">
                        Sign In
                    </button>
                </form>

                <a href="{{ route('home') }}" class="mt-8 block text-center text-xs uppercase tracking-[0.2em] text-neutral-500 hover:text-gold-300">
                    &larr; Back to Store
                </a>
            </div>
        </div>
    </div>
</body>
</html>
