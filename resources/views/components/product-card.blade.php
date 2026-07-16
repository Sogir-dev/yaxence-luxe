@props(['product'])

<a href="{{ route('products.show', $product) }}" class="group block">
    <div class="aspect-[3/4] w-full overflow-hidden rounded-sm border border-gold-900/30">
        <x-product-visual :product="$product" class="transition duration-500 group-hover:scale-105" />
    </div>
    <div class="mt-4 flex items-start justify-between gap-2">
        <div>
            <p class="text-[10px] font-medium uppercase tracking-[0.2em] text-gold-400">{{ $product->category_label }}</p>
            <h3 class="mt-1 font-serif text-lg text-white group-hover:text-gold-200">{{ $product->name }}</h3>
            @if($product->concentration)
                <p class="text-xs text-neutral-500">{{ $product->concentration }} &middot; {{ $product->size_ml }}ml</p>
            @endif
        </div>
        <p class="shrink-0 text-sm font-medium text-neutral-200">&#8358;{{ number_format($product->price, 0) }}</p>
    </div>
    @if($product->stock <= 0)
        <p class="mt-1 text-xs font-medium text-red-400">Sold out</p>
    @endif
</a>
