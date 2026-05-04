@props([
    'href' => null,
    'variant' => 'primary', // primary|secondary|ghost|danger
    'size' => 'md', // sm|md
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center rounded-lg font-semibold transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-300 focus:ring-offset-slate-100 disabled:opacity-60 disabled:pointer-events-none';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
    ];

    $variants = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800 shadow-lg shadow-slate-900/15',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:border-slate-400 hover:bg-slate-50',
        'ghost' => 'text-slate-600 hover:text-slate-900 hover:bg-slate-100',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-500 shadow-lg shadow-rose-500/20',
    ];

    $classes = trim($base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['primary']));
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
