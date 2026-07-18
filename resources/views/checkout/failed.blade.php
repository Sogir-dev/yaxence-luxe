<x-layouts.app title="Payment Not Completed">
    <div class="mx-auto max-w-xl px-6 py-20 text-center lg:px-10">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-red-400">Payment Not Completed</p>
        <h1 class="mt-3 font-serif text-4xl text-white">Something went wrong</h1>
        <p class="mt-3 text-neutral-400">
            Your order #{{ $order->id }} wasn't charged, so nothing has been sent yet. This can happen if the
            payment was cancelled or declined. No stock was reserved — you're free to try again.
        </p>

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

        <form id="checkout-form" method="POST" action="{{ route('checkout.retry', $order) }}" class="mt-8">
            @csrf
            <button type="submit" class="w-full rounded-sm bg-gold-400 px-6 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
                Try Payment Again
            </button>
        </form>

        <a href="{{ route('cart.index') }}" class="mt-6 inline-block text-xs uppercase tracking-[0.2em] text-neutral-500 hover:text-gold-300">
            &larr; Back to Your Bag
        </a>
    </div>

    <x-payment-loading-overlay />
</x-layouts.app>
