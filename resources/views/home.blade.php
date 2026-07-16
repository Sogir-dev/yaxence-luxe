<x-layouts.app :title="config('app.name').' — A House of Fragrance'">
    {{-- Hero --}}
    <section id="hero-section" class="relative overflow-hidden border-b border-gold-900/30 bg-gradient-to-b from-neutral-950 via-black to-black">
        <div class="pointer-events-none absolute inset-0 z-0">
            <div class="absolute -top-24 left-1/2 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-gold-500/10 blur-3xl"></div>
        </div>

        <canvas id="bottle-spray" class="pointer-events-none absolute inset-0 z-[5] h-full w-full"></canvas>

        <div class="relative z-10 mx-auto grid max-w-7xl grid-cols-1 items-center gap-4 px-6 py-20 lg:grid-cols-2 lg:gap-12 lg:px-10 lg:py-32">
            <div class="flex flex-col items-center gap-8 text-center lg:order-1 lg:items-start lg:text-left">
                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-gold-300">A House of Fragrance</p>
                <h1 class="max-w-xl font-serif text-5xl font-medium leading-tight text-white sm:text-6xl lg:text-7xl">
                    Scent is the memory <span class="italic text-gold-300">you leave behind</span>
                </h1>
                <p class="max-w-xl text-base text-neutral-400">
                    Discover YAXENCE LUXE — meticulously composed perfumes and body sprays across Men's, Women's,
                    and Unisex collections, crafted for those who make an entrance.
                </p>
                <div class="mt-4 flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                    <a href="{{ route('products.index') }}" class="rounded-sm bg-gold-400 px-8 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-black transition hover:bg-gold-300">
                        Shop All Fragrances
                    </a>
                    <a href="#collections" class="rounded-sm border border-neutral-700 px-8 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-200 transition hover:border-gold-400 hover:text-gold-300">
                        Explore Collections
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-center lg:order-2">
                <div id="bottle-stage" class="hero-visual relative w-56 sm:w-72 lg:w-96">
                    <img id="hero-bottle-image" src="{{ asset('images/hero-perfume.jpg') }}" alt="YAXENCE LUXE signature fragrance"
                         class="block w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    {{-- Collections --}}
    <section id="collections" class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
        <div class="mb-12 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Shop By Collection</p>
            <h2 class="mt-3 font-serif text-3xl text-white sm:text-4xl">Three Worlds of Scent</h2>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            @foreach([
                ['label' => "Men's Collection", 'slug' => 'men', 'copy' => 'Bold, grounded, unforgettable.'],
                ['label' => "Women's Collection", 'slug' => 'women', 'copy' => 'Radiant, romantic, refined.'],
                ['label' => 'Unisex Collection', 'slug' => 'unisex', 'copy' => 'Beyond boundaries, beyond gender.'],
            ] as $tile)
                @php
                    $lifestylePhoto = null;
                    foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
                        $relativePath = "images/collections/{$tile['slug']}.{$extension}";
                        if (file_exists(public_path($relativePath))) {
                            $lifestylePhoto = asset($relativePath);
                            break;
                        }
                    }
                    $tileProduct = $showcase->firstWhere('category', $tile['slug']);
                @endphp
                <a href="{{ route('products.index', ['category' => $tile['slug']]) }}"
                   class="group relative flex h-80 flex-col justify-end overflow-hidden rounded-sm border border-gold-900/30 bg-neutral-950 p-8">
                    @if($lifestylePhoto)
                        <img src="{{ $lifestylePhoto }}" alt="{{ $tile['label'] }}"
                             class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-black/10"></div>
                    @elseif($tileProduct)
                        <x-product-visual :product="$tileProduct" class="absolute inset-0 transition duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 opacity-70 transition duration-500 group-hover:scale-105"
                             style="background: radial-gradient(circle at 50% 20%, {{ $tile['slug'] === 'men' ? '#5b6472' : ($tile['slug'] === 'women' ? '#c98a93' : '#d4af6a') }}22, transparent 70%);"></div>
                    @endif
                    <div class="relative">
                        <p class="text-xs uppercase tracking-[0.3em] text-gold-300">{{ $tile['copy'] }}</p>
                        <h3 class="mt-2 font-serif text-2xl text-white">{{ $tile['label'] }}</h3>
                        <span class="mt-4 inline-block text-xs uppercase tracking-[0.2em] text-neutral-300 transition group-hover:text-gold-300">
                            Discover &rarr;
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured --}}
    @if($featured->isNotEmpty())
        <section class="border-t border-gold-900/30 bg-neutral-950 py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <div class="mb-12 text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">Signature Pieces</p>
                    <h2 class="mt-3 font-serif text-3xl text-white sm:text-4xl">Featured Fragrances</h2>
                </div>

                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($featured as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('products.index') }}" class="inline-block rounded-sm border border-neutral-700 px-8 py-3 text-xs font-semibold uppercase tracking-[0.2em] text-neutral-200 transition hover:border-gold-400 hover:text-gold-300">
                        View All Fragrances
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if($showcase->isNotEmpty())
        <section class="border-t border-gold-900/30 bg-black py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <div class="mb-10 text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">A Scent For Every Story</p>
                    <h2 class="mt-3 font-serif text-3xl text-white sm:text-4xl">Three Worlds, One House</h2>
                </div>
            </div>

            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-6 sm:grid-cols-3 lg:px-10">
                @foreach($showcase as $item)
                    <a href="{{ route('products.show', $item) }}"
                       class="group relative h-[420px] w-full overflow-hidden rounded-sm border border-gold-900/30">
                        <x-product-visual :product="$item" class="transition duration-700 group-hover:scale-105" />
                        <div class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-black via-black/20 to-transparent p-6">
                            <p class="text-xs uppercase tracking-[0.3em] text-gold-300">{{ $item->category_label }} Collection</p>
                            <h3 class="mt-2 font-serif text-2xl text-white">{{ $item->name }}</h3>
                            <span class="mt-3 inline-block text-xs uppercase tracking-[0.2em] text-neutral-300 transition group-hover:text-gold-300">
                                Discover &rarr;
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Bestsellers --}}
    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
        <div class="mb-12 flex items-end justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gold-300">The Full Collection</p>
                <h2 class="mt-3 font-serif text-3xl text-white sm:text-4xl">Bestsellers</h2>
            </div>
            <a href="{{ route('products.index') }}" class="hidden text-xs uppercase tracking-[0.2em] text-neutral-300 hover:text-gold-300 sm:block">
                View All &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($bestsellers as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Cinematic statement --}}
    <section class="relative overflow-hidden border-t border-gold-900/30 bg-gradient-to-b from-neutral-950 via-black to-neutral-950 py-24">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-1/2 top-1/2 h-[42rem] w-[42rem] -translate-x-1/2 -translate-y-1/2 rounded-full bg-gold-500/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-4xl px-6 text-center lg:px-10">
            <x-rotating-badge />

            <h2 class="mt-10 font-serif text-4xl text-white sm:text-5xl">Crafted With Intention</h2>
            <p class="mx-auto mt-4 max-w-xl text-neutral-400">
                Every YAXENCE LUXE fragrance begins with rare ingredients — oud, saffron, sandalwood —
                blended in small batches and built to last from morning into evening.
            </p>

            <div class="mt-16 grid grid-cols-3 gap-6 border-t border-gold-900/20 pt-12 sm:gap-8">
                <div>
                    <p class="stat-counter font-serif text-4xl text-gold-300 sm:text-5xl" data-target="12" data-decimals="0">0</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.2em] text-neutral-400 sm:text-xs sm:tracking-[0.25em]">Signature Scents</p>
                </div>
                <div>
                    <p class="stat-counter font-serif text-4xl text-gold-300 sm:text-5xl" data-target="4.9" data-decimals="1">0</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.2em] text-neutral-400 sm:text-xs sm:tracking-[0.25em]">Average Rating</p>
                </div>
                <div>
                    <p class="stat-counter font-serif text-4xl text-gold-300 sm:text-5xl" data-target="3" data-decimals="0">0</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.2em] text-neutral-400 sm:text-xs sm:tracking-[0.25em]">Curated Collections</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
