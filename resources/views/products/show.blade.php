<x-layouts.app :title="$product->name.' — '.config('app.name')">
    <div class="mx-auto max-w-7xl px-6 py-10 lg:px-10">
        <a href="{{ route('products.index', ['category' => $product->category]) }}" class="text-xs uppercase tracking-[0.2em] text-neutral-400 hover:text-gold-300">
            &larr; {{ $product->category_label }} Collection
        </a>

        <div class="mt-8 grid grid-cols-1 gap-14 lg:grid-cols-2">
            <div class="aspect-[3/4] w-full overflow-hidden rounded-sm border border-gold-900/30">
                <x-product-visual :product="$product" />
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-400">{{ $product->category_label }} &middot; {{ $product->concentration }}</p>
                <h1 class="mt-3 font-serif text-4xl text-white">{{ $product->name }}</h1>
                <p class="mt-4 text-2xl text-neutral-200">&#8358;{{ number_format($product->price, 0) }}</p>
                <p class="mt-1 text-xs text-neutral-500">{{ $product->size_ml }}ml</p>

                <p class="mt-6 leading-relaxed text-neutral-400">{{ $product->description }}</p>

                @if($product->top_notes || $product->heart_notes || $product->base_notes)
                    <div class="mt-8 space-y-3 border-t border-neutral-800 pt-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Scent Profile</p>
                        @if($product->top_notes)
                            <div class="flex gap-4 text-sm">
                                <span class="w-20 shrink-0 text-neutral-500">Top</span>
                                <span class="text-neutral-200">{{ $product->top_notes }}</span>
                            </div>
                        @endif
                        @if($product->heart_notes)
                            <div class="flex gap-4 text-sm">
                                <span class="w-20 shrink-0 text-neutral-500">Heart</span>
                                <span class="text-neutral-200">{{ $product->heart_notes }}</span>
                            </div>
                        @endif
                        @if($product->base_notes)
                            <div class="flex gap-4 text-sm">
                                <span class="w-20 shrink-0 text-neutral-500">Base</span>
                                <span class="text-neutral-200">{{ $product->base_notes }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                @if($product->stock > 0)
                    <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 flex items-center gap-3">
                        @csrf
                        <label for="quantity" class="text-sm text-neutral-400">Qty</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="w-20 rounded-sm border-neutral-700 bg-neutral-900 text-sm text-white">
                        <button type="submit" class="rounded-sm bg-gold-400 px-8 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-black hover:bg-gold-300">
                            Add to Bag
                        </button>
                    </form>
                    <p class="mt-3 text-xs text-neutral-500">{{ $product->stock }} in stock</p>
                @else
                    <p class="mt-8 text-sm font-medium text-red-400">This fragrance is sold out.</p>
                @endif
            </div>
        </div>

        @if($related->isNotEmpty())
            <div class="mt-24">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">You May Also Like</p>
                <h2 class="mt-3 font-serif text-2xl text-white">More From {{ $product->category_label }}</h2>

                <div class="mt-8 grid grid-cols-1 gap-8 sm:grid-cols-3">
                    @foreach($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
