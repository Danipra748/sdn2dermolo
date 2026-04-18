@props([
    'variant' => 'default', // default, success, warning, danger, info
])

@php
    $variants = [
        'default' => 'bg-slate-100 text-slate-700 border-slate-200',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-100',
        'danger'  => 'bg-rose-50 text-rose-700 border-rose-100',
        'info'    => 'bg-blue-50 text-blue-700 border-blue-100',
    ];

    $classes = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.65rem] font-black uppercase tracking-wider border ' . ($variants[$variant] ?? $variants['default']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
