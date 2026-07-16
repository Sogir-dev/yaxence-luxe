<x-layouts.app title="Order Confirmed">
    <div class="mx-auto max-w-xl px-6 py-20 text-center lg:px-10">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Order Confirmed</p>
        <h1 class="mt-3 font-serif text-4xl text-white">Thank you, {{ $order->customer_name }}</h1>
        <p class="mt-3 text-neutral-400">Your order #{{ $order->id }} has been placed.</p>

        @if($isGuest ?? false)
            <div id="signup-nudge" class="mt-8 rounded-sm border border-gold-700/40 bg-gold-900/10 p-6 text-left">
                <p class="font-serif text-lg text-white">Want to track your delivery?</p>
                <p class="mt-2 text-sm text-neutral-400">
                    Create a free account and you'll be able to follow this order (and every future one) from your dashboard.
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}?email={{ urlencode($order->customer_email) }}"
                       class="rounded-sm bg-gold-400 px-6 py-2.5 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
                        Sign Up to Track
                    </a>
                    <button type="button" onclick="document.getElementById('signup-nudge').remove()"
                            class="rounded-sm border border-neutral-700 px-6 py-2.5 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-300 hover:border-gold-400 hover:text-gold-300">
                        Not Now
                    </button>
                </div>
            </div>
        @endif

        <div class="mt-10 rounded-sm border border-gold-900/30 bg-neutral-950 p-6 text-left">
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-neutral-300">{{ $item->product_name }} &times; {{ $item->quantity }}</span>
                        <span class="text-neutral-200">&#8358;{{ number_format($item->subtotal, 0) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 flex justify-between border-t border-neutral-800 pt-5 font-medium">
                <span class="text-white">Total</span>
                <span class="text-gold-300">&#8358;{{ number_format($order->total, 0) }}</span>
            </div>
        </div>

        <div class="mt-6 space-y-1 text-left text-sm text-neutral-400">
            <p><span class="font-medium text-neutral-200">Shipping to:</span> {{ $order->shipping_address }}</p>
            <p><span class="font-medium text-neutral-200">Confirmation sent to:</span> {{ $order->customer_email }}</p>
            <p><span class="font-medium text-neutral-200">Contact number:</span> {{ $order->customer_phone }}</p>
        </div>

        <a href="{{ route('products.index') }}" class="mt-10 inline-block text-xs uppercase tracking-[0.2em] text-gold-300 underline hover:text-gold-200">
            Continue Shopping
        </a>
    </div>
</x-layouts.app>
