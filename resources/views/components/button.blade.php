@props([
    'href' => null,          // kalau diisi, tombol jadi <a>
    'variant' => 'primary',  // primary | outline | ghost
    'size' => 'md',          // sm | md
    'type' => 'button',      // untuk <button>
])

@php
    $base = 'inline-flex items-center justify-center rounded-xl font-semibold transition focus:outline-none focus:ring-1 focus:ring-emerald-400';

    $variants = [
    'primary' => 'bg-emerald-400 text-slate-950 hover:bg-emerald-300',
    'outline' => 'border border-slate-600 text-slate-100 hover:border-emerald-400 hover:text-emerald-300',
    'ghost'   => 'text-slate-300 hover:text-emerald-300',

    // ✅ BARU: soft / secondary CTA
    'soft'    => 'bg-emerald-400/10 text-emerald-300 ring-1 ring-emerald-400/30 hover:bg-emerald-400/15',
];


    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
    ];

    $classes = $base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
