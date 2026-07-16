<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-950 text-neutral-100 antialiased font-sans">
    <div class="flex min-h-screen">
        <aside class="hidden w-56 shrink-0 border-r border-gold-900/30 bg-black md:block">
            <div class="px-6 py-6">
                <a href="{{ route('admin.products.index') }}" class="font-serif text-lg tracking-[0.15em] text-gold-200">YAXENCE <span class="text-white">ADMIN</span></a>
            </div>
            <nav class="mt-4 flex flex-col gap-1 px-3 text-sm">
                <a href="{{ route('admin.products.index') }}"
                   class="rounded-sm px-3 py-2 {{ request()->routeIs('admin.products.index') ? 'bg-gold-400 text-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                    Products
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center justify-between rounded-sm px-3 py-2 {{ request()->routeIs('admin.orders.*') ? 'bg-gold-400 text-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                    <span>Orders</span>
                    @php($pendingCount = \App\Models\Order::where('status', 'pending')->where('payment_status', 'paid')->count())
                    @if($pendingCount > 0)
                        <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1.5 text-[10px] font-semibold text-white">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.products.create') }}"
                   class="rounded-sm px-3 py-2 {{ request()->routeIs('admin.products.create') ? 'bg-gold-400 text-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                    Add Product
                </a>
                <a href="{{ route('admin.products.import') }}"
                   class="rounded-sm px-3 py-2 {{ request()->routeIs('admin.products.import') ? 'bg-gold-400 text-black' : 'text-neutral-300 hover:bg-neutral-900' }}">
                    Bulk Import
                </a>
                <a href="{{ route('home') }}" target="_blank" class="mt-2 rounded-sm px-3 py-2 text-neutral-500 hover:bg-neutral-900">
                    View Store &rarr;
                </a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="flex items-center justify-between border-b border-gold-900/30 bg-black px-6 py-4 md:hidden">
                <a href="{{ route('admin.products.index') }}" class="font-serif text-base tracking-[0.15em] text-gold-200">YAXENCE ADMIN</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="text-xs uppercase tracking-wide text-neutral-400">Logout</button>
                </form>
            </header>

            <header class="hidden items-center justify-between border-b border-gold-900/30 px-8 py-4 md:flex">
                <h1 class="font-serif text-xl text-white">{{ $title ?? 'Admin' }}</h1>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="text-xs uppercase tracking-wide text-neutral-400 hover:text-gold-300">Logout</button>
                </form>
            </header>

            <main class="px-6 py-8 md:px-8">
                @if(session('status'))
                    <div class="mb-6 rounded-sm border border-gold-700/50 bg-gold-900/20 px-4 py-3 text-sm text-gold-100">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-sm border border-red-800 bg-red-950/50 px-4 py-3 text-sm text-red-200">
                        <ul class="list-inside list-disc">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
