@props(['product'])

@php
    $palette = match ($product->category) {
        'men' => ['glass1' => '#2b2f36', 'glass2' => '#12141a', 'glow' => '#5b6472'],
        'women' => ['glass1' => '#5a3a3f', 'glass2' => '#2a1418', 'glow' => '#c98a93'],
        default => ['glass1' => '#3d3320', 'glass2' => '#171207', 'glow' => '#d4af6a'],
    };
    $uid = 'bottle-'.$product->id;
@endphp

<div {{ $attributes->merge(['class' => 'relative flex h-full w-full items-center justify-center overflow-hidden bg-gradient-to-b from-black to-neutral-900']) }}>
    <div class="absolute inset-0 opacity-40" style="background: radial-gradient(circle at 50% 30%, {{ $palette['glow'] }}33, transparent 65%);"></div>

    @if($product->photo_url)
        <img src="{{ $product->photo_url }}" alt="{{ $product->name }}" class="relative h-full w-full object-cover">
    @else
    <svg viewBox="0 0 200 320" class="relative h-[78%] w-auto drop-shadow-[0_10px_25px_rgba(0,0,0,0.5)]">
        <defs>
            <linearGradient id="{{ $uid }}-glass" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="{{ $palette['glass1'] }}" />
                <stop offset="100%" stop-color="{{ $palette['glass2'] }}" />
            </linearGradient>
            <linearGradient id="{{ $uid }}-gold" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#f3d998" />
                <stop offset="50%" stop-color="#caa24d" />
                <stop offset="100%" stop-color="#8a6c2f" />
            </linearGradient>
        </defs>

        <ellipse cx="100" cy="300" rx="42" ry="8" fill="black" opacity="0.35" />

        <rect x="88" y="18" width="24" height="26" rx="3" fill="url(#{{ $uid }}-gold)" stroke="#000" stroke-opacity="0.15" />
        <rect x="82" y="40" width="36" height="14" rx="4" fill="url(#{{ $uid }}-gold)" />

        <path d="M78 54 h44 a6 6 0 0 1 6 6 v18 a10 10 0 0 0 3 7 c9 9 14 22 14 38 v150 a10 10 0 0 1 -10 10 H65 a10 10 0 0 1 -10 -10 V123 c0 -16 5 -29 14 -38 a10 10 0 0 0 3 -7 V60 a6 6 0 0 1 6 -6 Z"
              fill="url(#{{ $uid }}-glass)" stroke="{{ $palette['glow'] }}" stroke-opacity="0.35" stroke-width="1" />

        <rect x="58" y="150" width="84" height="66" rx="2" fill="black" opacity="0.28" />
        <text x="100" y="178" text-anchor="middle" fill="{{ $palette['glow'] }}" font-family="serif" font-size="11" letter-spacing="2">YAXENCE</text>
        <text x="100" y="192" text-anchor="middle" fill="#f3d998" font-family="serif" font-size="9" letter-spacing="4">LUXE</text>
        <line x1="72" y1="200" x2="128" y2="200" stroke="{{ $palette['glow'] }}" stroke-opacity="0.5" stroke-width="0.5" />
        <text x="100" y="209" text-anchor="middle" fill="#e8e8e8" font-family="serif" font-size="6" letter-spacing="1" opacity="0.85">{{ strtoupper($product->category_label) }}</text>

        <rect x="70" y="70" width="8" height="140" rx="4" fill="white" opacity="0.08" />
    </svg>
    @endif
</div>
