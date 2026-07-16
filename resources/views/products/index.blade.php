@php
    $categories = [
        null => 'All Fragrances',
        'men' => "Men's",
        'women' => "Women's",
        'unisex' => 'Unisex',
    ];
@endphp

<x-layouts.app :title="($category ? $categories[$category].' Collection — ' : '').config('app.name')">
    <section class="border-b border-gold-900/30 bg-neutral-950 py-16">
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-10">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">The Collection</p>
            <h1 class="mt-3 font-serif text-4xl text-white sm:text-5xl">
                {{ $category ? $categories[$category] : 'All Fragrances' }}
            </h1>
            @if($search)
                <p class="mt-4 text-sm text-neutral-400">
                    Showing results for &ldquo;{{ $search }}&rdquo; &middot; {{ $products->total() }} found
                    <a href="{{ route('products.index', array_filter(['category' => $category])) }}" class="ml-2 text-gold-300 hover:underline">Clear</a>
                </p>
            @endif
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
        <div class="mb-10 flex flex-wrap items-center justify-center gap-3">
            @foreach($categories as $slug => $label)
                <a href="{{ route('products.index', array_filter(['category' => $slug, 'search' => $search])) }}"
                   class="rounded-full border px-5 py-2 text-xs font-semibold uppercase tracking-[0.15em] transition
                          {{ $category === $slug ? 'border-gold-400 bg-gold-400 text-black' : 'border-neutral-700 text-neutral-300 hover:border-gold-400 hover:text-gold-300' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if($products->isEmpty())
            <p class="text-center text-neutral-500">
                @if($search)
                    No fragrances match &ldquo;{{ $search }}&rdquo;.
                @else
                    No fragrances found in this collection yet.
                @endif
            </p>
        @else
            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-14">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
