<x-layouts.auth title="Reset Password">
    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Almost There</p>
    <h1 class="mt-3 font-serif text-3xl text-white">Enter Your Code</h1>
    <p class="mt-2 text-sm text-neutral-500">We sent a 6-digit code to {{ $email }}. Enter it below with your new password.</p>

    <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-5">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="code" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">6-Digit Code</label>
            <input type="text" id="code" name="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autofocus
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-center text-2xl tracking-[0.5em] text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30"
                placeholder="000000">
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">New Password</label>
            <input type="password" id="password" name="password" required
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600 focus:border-gold-400 focus:ring-gold-400/30">
        </div>

        <button type="submit" class="w-full rounded-sm bg-gold-400 px-6 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black transition hover:bg-gold-300">
            Reset Password
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-neutral-500">
        Didn't get a code? <a href="{{ route('password.request') }}" class="text-gold-300 hover:underline">Try again</a>
    </p>
</x-layouts.auth>
