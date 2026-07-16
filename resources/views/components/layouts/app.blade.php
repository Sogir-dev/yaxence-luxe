@php
    $navLinks = [
        'Men' => 'men',
        'Women' => 'women',
        'Unisex' => 'unisex',
    ];
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="YAXENCE LUXE — a house of fragrance. Discover men's, women's, and unisex perfume collections crafted for those who leave an impression.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-neutral-100 antialiased font-sans">
    <header class="sticky top-0 z-40 border-b border-gold-900/40 bg-black/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-10">
            <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold tracking-[0.2em] text-gold-200">
                YAXENCE <span class="text-white">LUXE</span>
            </a>

            <nav class="hidden items-center gap-10 text-xs font-medium tracking-[0.2em] text-neutral-300 md:flex">
                @foreach($navLinks as $label => $slug)
                    <a href="{{ route('products.index', ['category' => $slug]) }}" class="uppercase transition hover:text-gold-300">
                        {{ $label }}
                    </a>
                @endforeach
                <a href="{{ route('products.index') }}" class="uppercase transition hover:text-gold-300">All Fragrances</a>
            </nav>

            <div class="flex items-center gap-5">
                <button type="button" id="search-toggle" aria-expanded="false" aria-controls="search-bar"
                        class="text-neutral-200 hover:text-gold-300" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>

                @auth
                    <div class="hidden items-center gap-4 md:flex">
                        <a href="{{ route('customer.orders.index') }}" class="text-xs font-medium uppercase tracking-[0.15em] text-neutral-200 hover:text-gold-300">
                            My Orders
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-medium uppercase tracking-[0.15em] text-neutral-500 hover:text-gold-300">Logout</button>
                        </form>
                    </div>
                    <a href="{{ route('customer.orders.index') }}" class="text-neutral-200 hover:text-gold-300 md:hidden" aria-label="My Orders">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-neutral-200 hover:text-gold-300" aria-label="Sign in">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </a>
                @endauth

                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 text-neutral-200 hover:text-gold-300 md:text-xs md:font-medium md:tracking-[0.15em]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.508-7.164a1.125 1.125 0 00-1.1-1.336H5.106M7.5 14.25L5.106 5.25M7.5 14.25L4.5 5.25m3 9L2.25 3" />
                    </svg>
                    <span class="hidden uppercase md:inline">Bag</span>
                    @php($count = app(\App\Services\Cart::class)->count())
                    @if($count > 0)
                        <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-gold-400 text-[10px] font-semibold text-black md:static md:h-5 md:min-w-5 md:px-1.5 md:text-[11px]">{{ $count }}</span>
                    @endif
                </a>

                <button type="button" id="menu-toggle" aria-expanded="false" aria-controls="mobile-menu"
                        class="flex h-8 w-8 flex-col items-center justify-center gap-1.5 md:hidden" aria-label="Toggle menu">
                    <span id="menu-bar-1" class="block h-px w-6 bg-neutral-200 transition duration-300"></span>
                    <span id="menu-bar-2" class="block h-px w-6 bg-neutral-200 transition duration-300"></span>
                    <span id="menu-bar-3" class="block h-px w-6 bg-neutral-200 transition duration-300"></span>
                </button>
            </div>
        </div>

        <div id="search-bar" class="hidden border-t border-gold-900/20 bg-neutral-950 px-6 py-4 lg:px-10">
            <form method="GET" action="{{ route('products.index') }}" class="mx-auto flex max-w-2xl items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="search" name="search" placeholder="Search fragrances..." autocomplete="off"
                    class="w-full border-0 bg-transparent text-white placeholder:text-neutral-500 focus:outline-none focus:ring-0">
            </form>
        </div>

        <div id="mobile-menu" class="hidden border-t border-gold-900/20 md:hidden">
            <nav class="flex flex-col divide-y divide-gold-900/10 px-6">
                @foreach($navLinks as $label => $slug)
                    <a href="{{ route('products.index', ['category' => $slug]) }}" class="py-4 text-sm font-medium uppercase tracking-[0.2em] text-neutral-200 hover:text-gold-300">
                        {{ $label }}
                    </a>
                @endforeach
                <a href="{{ route('products.index') }}" class="py-4 text-sm font-medium uppercase tracking-[0.2em] text-neutral-200 hover:text-gold-300">All Fragrances</a>
                <a href="{{ route('cart.index') }}" class="py-4 text-sm font-medium uppercase tracking-[0.2em] text-neutral-200 hover:text-gold-300">Your Bag</a>
                @auth
                    <a href="{{ route('customer.orders.index') }}" class="py-4 text-sm font-medium uppercase tracking-[0.2em] text-neutral-200 hover:text-gold-300">My Orders</a>
                    <form method="POST" action="{{ route('logout') }}" class="py-4">
                        @csrf
                        <button type="submit" class="text-sm font-medium uppercase tracking-[0.2em] text-neutral-400 hover:text-gold-300">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="py-4 text-sm font-medium uppercase tracking-[0.2em] text-neutral-200 hover:text-gold-300">Sign In</a>
                    <a href="{{ route('register') }}" class="py-4 text-sm font-medium uppercase tracking-[0.2em] text-neutral-200 hover:text-gold-300">Create Account</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @if(session('status'))
            <div class="mx-auto mt-6 max-w-7xl px-6 lg:px-10">
                <div class="rounded-sm border border-gold-700/50 bg-gold-900/20 px-4 py-3 text-sm text-gold-100">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-auto mt-6 max-w-7xl px-6 lg:px-10">
                <div class="rounded-sm border border-red-800 bg-red-950/50 px-4 py-3 text-sm text-red-200">
                    <ul class="list-inside list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="mt-24 border-t border-gold-900/40 bg-neutral-950">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-6 py-16 sm:grid-cols-2 lg:grid-cols-4 lg:px-10">
            <div>
                <p class="font-serif text-xl tracking-[0.2em] text-gold-200">YAXENCE LUXE</p>
                <p class="mt-4 text-sm leading-relaxed text-neutral-400">
                    A house of fragrance crafting distinctive scents for men, women, and everyone in between.
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-300">Collections</p>
                <ul class="mt-4 space-y-2 text-sm text-neutral-400">
                    @foreach($navLinks as $label => $slug)
                        <li><a href="{{ route('products.index', ['category' => $slug]) }}" class="hover:text-gold-300">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-300">Client Care</p>
                <ul class="mt-4 space-y-2 text-sm text-neutral-400">
                    <li><a href="{{ route('cart.index') }}" class="hover:text-gold-300">Your Bag</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-gold-300">Shop All</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-neutral-300">Stay Connected</p>
                <p class="mt-4 text-sm text-neutral-400">Be the first to know about new scents and private releases.</p>
                <form class="mt-4 flex overflow-hidden rounded-sm border border-neutral-700">
                    <input type="email" placeholder="Email address" class="w-full border-0 bg-transparent px-3 py-2 text-sm text-neutral-100 placeholder:text-neutral-500 focus:outline-none focus:ring-0">
                    <button type="submit" class="bg-gold-400 px-4 text-xs font-semibold uppercase tracking-wide text-black hover:bg-gold-300">Join</button>
                </form>
            </div>
        </div>

        <div class="mx-auto flex max-w-7xl flex-col items-center justify-center gap-2 border-t border-neutral-900 px-6 py-6 text-center text-xs tracking-wide text-neutral-500 sm:flex-row sm:justify-between lg:px-10">
            <span>&copy; {{ date('Y') }} YAXENCE LUXE. All rights reserved.</span>
            <a href="{{ route('admin.login') }}" class="text-neutral-700 hover:text-neutral-400">Admin</a>
        </div>
    </footer>
</body>
</html>
