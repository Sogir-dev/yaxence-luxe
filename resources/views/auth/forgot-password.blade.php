<x-layouts.auth title="Forgot Password">
    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Account Recovery</p>
    <h1 class="mt-3 font-serif text-3xl text-white">Forgot Password?</h1>
    <p class="mt-2 text-sm text-neutral-500">Enter your email and we'll send a 6-digit code to verify it's you.</p>

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
        </div>

        <button type="submit" class="w-full rounded-sm bg-gold-400 px-6 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black transition hover:bg-gold-300">
            Send Reset Code
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-neutral-500">
        Remembered it? <a href="{{ route('login') }}" class="text-gold-300 hover:underline">Sign in</a>
    </p>
</x-layouts.auth>
