<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Account' }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-neutral-100 antialiased font-sans">
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
        <div class="relative hidden flex-col justify-between overflow-hidden bg-gradient-to-br from-neutral-950 via-black to-neutral-900 p-12 lg:flex">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-24 top-1/4 h-[28rem] w-[28rem] rounded-full bg-gold-500/10 blur-3xl"></div>
                <div class="absolute -right-24 bottom-0 h-[24rem] w-[24rem] rounded-full bg-gold-500/10 blur-3xl"></div>
            </div>

            <a href="{{ route('home') }}" class="relative font-serif text-2xl tracking-[0.2em] text-gold-200">
                YAXENCE <span class="text-white">LUXE</span>
            </a>

            <div class="relative">
                <x-rotating-badge />
            </div>

            <blockquote class="relative">
                <p class="font-serif text-2xl italic leading-relaxed text-neutral-200">
                    &ldquo;{{ $quote ?? 'Scent is the memory you leave behind.' }}&rdquo;
                </p>
                <p class="mt-4 text-xs uppercase tracking-[0.3em] text-neutral-500">A House of Fragrance</p>
            </blockquote>
        </div>

        <div class="flex flex-col items-center justify-center px-6 py-12 sm:px-10">
            <a href="{{ route('home') }}" class="mb-10 font-serif text-xl tracking-[0.2em] text-gold-200 lg:hidden">
                YAXENCE <span class="text-white">LUXE</span>
            </a>

            <div class="w-full max-w-sm">
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
            </div>
        </div>
    </div>
</body>
</html>
