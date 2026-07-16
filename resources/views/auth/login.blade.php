<x-layouts.auth title="Sign In">
    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Welcome Back</p>
    <h1 class="mt-3 font-serif text-3xl text-white">Sign In</h1>
    <p class="mt-2 text-sm text-neutral-500">Access your orders, wishlist, and delivery tracking.</p>

    <a href="{{ route('auth.google') }}"
       class="mt-8 flex w-full items-center justify-center gap-3 rounded-sm border border-neutral-700 bg-neutral-900 px-6 py-3 text-sm font-medium text-neutral-100 transition hover:border-gold-400 hover:text-gold-200">
        <x-google-icon />
        Continue with Google
    </a>

    <div class="my-6 flex items-center gap-4">
        <div class="h-px flex-1 bg-neutral-800"></div>
        <span class="text-xs uppercase tracking-[0.2em] text-neutral-600">or</span>
        <div class="h-px flex-1 bg-neutral-800"></div>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs text-neutral-500 hover:text-gold-300">Forgot?</a>
            </div>
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

    <p class="mt-8 text-center text-sm text-neutral-500">
        New to YAXENCE LUXE?
        <a href="{{ route('register') }}" class="text-gold-300 hover:underline">Create an account</a>
    </p>
</x-layouts.auth>
