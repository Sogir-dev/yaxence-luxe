<x-layouts.app title="Your Orders">
    <div class="mx-auto max-w-4xl px-6 py-14 lg:px-10">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Delivery Tracking</p>
        <h1 class="mt-3 font-serif text-4xl text-white">Your Orders</h1>

        @if($orders->isEmpty())
            <p class="mt-8 text-neutral-400">
                You haven't placed any orders yet.
                <a href="{{ route('products.index') }}" class="text-gold-300 underline">Start shopping</a>.
            </p>
        @else
            <div class="mt-10 divide-y divide-neutral-800 border-y border-neutral-800">
                @foreach($orders as $order)
                    <a href="{{ route('customer.orders.show', $order) }}" class="flex items-center justify-between gap-4 py-5 hover:bg-neutral-950">
                        <div>
                            <p class="font-serif text-lg text-white">Order #{{ $order->id }}</p>
                            <p class="mt-1 text-sm text-neutral-500">{{ $order->created_at->format('M j, Y') }} &middot; {{ $order->items->count() }} item(s)</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-white">&#8358;{{ number_format($order->total, 0) }}</p>
                            <span class="mt-1 inline-block rounded-full border border-gold-900/40 px-3 py-1 text-[10px] font-semibold uppercase tracking-wide text-gold-300">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
