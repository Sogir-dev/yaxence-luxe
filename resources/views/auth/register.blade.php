<x-layouts.auth title="Create Account" quote="Every fragrance begins with rare ingredients and ends only when it feels inevitable.">
    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Join The House</p>
    <h1 class="mt-3 font-serif text-3xl text-white">Create Your Account</h1>
    <p class="mt-2 text-sm text-neutral-500">Track orders, save favorites, and check out faster.</p>

    <a href="{{ route('auth.google') }}"
       class="mt-8 flex w-full items-center justify-center gap-3 rounded-sm border border-neutral-700 bg-neutral-900 px-6 py-3 text-sm font-medium text-neutral-100 transition hover:border-gold-400 hover:text-gold-200">
        <x-google-icon />
        Sign up with Google
    </a>

    <div class="my-6 flex items-center gap-4">
        <div class="h-px flex-1 bg-neutral-800"></div>
        <span class="text-xs uppercase tracking-[0.2em] text-neutral-600">or</span>
        <div class="h-px flex-1 bg-neutral-800"></div>
    </div>

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
            </div>
            <div>
                <label for="last_name" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
            </div>
        </div>

        <div>
            <label for="phone" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Phone Number</label>
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="080..."
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', request('email')) }}" required
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
            </div>
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Confirm</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
            </div>
        </div>

        <button type="submit" class="w-full rounded-sm bg-gold-400 px-6 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black transition hover:bg-gold-300">
            Create Account
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-neutral-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-gold-300 hover:underline">Sign in</a>
    </p>
</x-layouts.auth>
