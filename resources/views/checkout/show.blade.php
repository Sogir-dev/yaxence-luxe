<x-layouts.app title="Checkout">
    <div class="mx-auto max-w-6xl px-6 py-14 lg:px-10">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Almost There</p>
        <h1 class="mt-3 font-serif text-4xl text-white">Checkout</h1>

        <div class="mt-10 grid grid-cols-1 gap-14 lg:grid-cols-3">
            <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6 lg:col-span-2">
                @csrf

                <div>
                    <label for="customer_name" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Full name</label>
                    <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $user?->name) }}" required
                        class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600">
                </div>

                <div>
                    <label for="customer_email" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Email</label>
                    <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $user?->email) }}" required
                        class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600">
                </div>

                <div>
                    <label for="customer_phone" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Phone number</label>
                    <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $user?->phone) }}" required placeholder="080..."
                        class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600">
                    <p class="mt-1 text-xs text-neutral-500">We'll use this to reach you about delivery.</p>
                </div>

                <div>
                    <label for="shipping_address" class="block text-xs font-semibold uppercase tracking-wide text-neutral-400">Shipping address</label>
                    <textarea id="shipping_address" name="shipping_address" rows="4" required
                        class="mt-2 w-full rounded-sm border-neutral-700 bg-neutral-900 text-white placeholder:text-neutral-600">{{ old('shipping_address') }}</textarea>
                </div>

                <button type="submit" class="w-full rounded-sm bg-gold-400 px-6 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
                    Proceed to Payment
                </button>
                <p class="text-center text-xs text-neutral-500">You'll be securely redirected to Paystack to complete your payment.</p>
            </form>

            <div class="rounded-sm border border-gold-900/30 bg-neutral-950 p-6">
                <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Order Summary</h2>
                <div class="mt-5 space-y-4">
                    @foreach($items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-neutral-300">{{ $item['product']->name }} &times; {{ $item['quantity'] }}</span>
                            <span class="text-neutral-200">&#8358;{{ number_format($item['subtotal'], 0) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 flex justify-between border-t border-neutral-800 pt-5 font-medium">
                    <span class="text-white">Total</span>
                    <span class="text-gold-300">&#8358;{{ number_format($total, 0) }}</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
