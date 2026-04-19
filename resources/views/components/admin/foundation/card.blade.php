@props([
    'padding' => 'md',  // sm, md, lg
    'header' => false,
    'footer' => false,
])

@php
    $paddingClasses = [
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
    ];
@endphp

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    @if($header ?? false)
        <div class="border-b border-slate-200 {{ $paddingClasses[$padding] ?? $paddingClasses['md'] }}">
            {{ $header }}
        </div>
    @endif

    <div class="{{ $paddingClasses[$padding] ?? $paddingClasses['md'] }}">
        {{ $slot }}
    </div>

    @if($footer ?? false)
        <div class="border-t border-slate-200 {{ $paddingClasses[$padding] ?? $paddingClasses['md'] }} bg-slate-50">
            {{ $footer }}
        </div>
    @endif
</div>
