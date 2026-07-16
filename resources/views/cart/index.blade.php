<x-layouts.app title="Your Bag">
    <div class="mx-auto max-w-4xl px-6 py-14 lg:px-10">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Your Selection</p>
        <h1 class="mt-3 font-serif text-4xl text-white">Your Bag</h1>

        @if($items->isEmpty())
            <p class="mt-8 text-neutral-400">Your bag is empty. <a href="{{ route('products.index') }}" class="text-gold-300 underline">Continue shopping</a>.</p>
        @else
            <div class="mt-10 divide-y divide-neutral-800 border-y border-neutral-800">
                @foreach($items as $item)
                    <div class="flex flex-col items-start gap-4 py-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="h-20 w-16 shrink-0 overflow-hidden rounded-sm border border-gold-900/30">
                                <x-product-visual :product="$item['product']" />
                            </div>
                            <div>
                                <a href="{{ route('products.show', $item['product']) }}" class="font-serif text-lg text-white hover:text-gold-200">
                                    {{ $item['product']->name }}
                                </a>
                                <p class="text-xs uppercase tracking-wide text-neutral-500">{{ $item['product']->category_label }} &middot; {{ $item['product']->concentration }}</p>
                                <p class="mt-1 text-sm text-neutral-400">&#8358;{{ number_format($item['product']->price, 0) }} each</p>
                            </div>
                        </div>

                        <div class="flex w-full items-center justify-between gap-4 sm:w-auto sm:justify-end">
                            <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="{{ $item['product']->stock }}"
                                    class="w-16 rounded-sm border-neutral-700 bg-neutral-900 text-sm text-white">
                                <button type="submit" class="text-xs uppercase tracking-wide text-neutral-400 underline hover:text-gold-300">Update</button>
                            </form>

                            <p class="w-20 text-right font-medium text-white">&#8358;{{ number_format($item['subtotal'], 0) }}</p>

                            <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs uppercase tracking-wide text-red-400 hover:underline">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                <a href="{{ route('products.index') }}" class="text-xs uppercase tracking-[0.2em] text-neutral-400 hover:text-gold-300">&larr; Continue Shopping</a>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-neutral-500">Total</p>
                    <p class="font-serif text-3xl text-white">&#8358;{{ number_format($total, 0) }}</p>
                </div>
            </div>

            <div class="mt-8 text-right">
                <a href="{{ route('checkout.show') }}" class="inline-block rounded-sm bg-gold-400 px-10 py-3.5 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
                    Proceed to Checkout
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>
