@props([
    'variant' => 'primary', // primary, secondary, outline, destructive, ghost
    'size' => 'md',       // sm, md, lg
    'type' => 'button',
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-bold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none active:scale-[0.98]';
    
    $variants = [
        'primary'     => 'bg-slate-900 text-white hover:bg-slate-800 shadow-sm',
        'secondary'   => 'bg-slate-100 text-slate-900 hover:bg-slate-200 border border-slate-200',
        'outline'     => 'bg-transparent border border-slate-300 text-slate-700 hover:bg-slate-50',
        'destructive' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm shadow-red-100',
        'ghost'       => 'bg-transparent text-slate-600 hover:bg-slate-100',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-lg',
        'md' => 'px-5 py-2.5 text-sm rounded-xl',
        'lg' => 'px-8 py-4 text-base rounded-2xl',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) {!! $icon !!} @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) {!! $icon !!} @endif
        {{ $slot }}
    </button>
@endif
