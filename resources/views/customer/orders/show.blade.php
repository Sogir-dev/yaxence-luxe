<x-layouts.app :title="'Order #'.$order->id">
    <div class="mx-auto max-w-2xl px-6 py-14 lg:px-10">
        <a href="{{ route('customer.orders.index') }}" class="text-xs uppercase tracking-[0.2em] text-neutral-400 hover:text-gold-300">
            &larr; Your Orders
        </a>

        <p class="mt-6 text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Order #{{ $order->id }}</p>
        <h1 class="mt-3 font-serif text-3xl text-white">
            {{ ucfirst($order->status) }}
        </h1>
        <p class="mt-2 text-sm text-neutral-500">Placed {{ $order->created_at->format('M j, Y \a\t g:ia') }}</p>

        <div class="mt-8 rounded-sm border border-gold-900/30 bg-neutral-950 p-6">
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

        <div class="mt-6 space-y-1 text-sm text-neutral-400">
            <p><span class="font-medium text-neutral-200">Shipping to:</span> {{ $order->shipping_address }}</p>
        </div>
    </div>
</x-layouts.app>
