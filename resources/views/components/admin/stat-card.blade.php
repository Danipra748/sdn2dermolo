@props([
    'title',
    'value',
    'description' => null,
    'icon' => null,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => 'text-blue-600 bg-blue-50 border-blue-100',
        'green' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
        'amber' => 'text-amber-600 bg-amber-50 border-amber-100',
        'purple' => 'text-purple-600 bg-purple-50 border-purple-100',
        'red' => 'text-rose-600 bg-rose-50 border-rose-100',
        'cyan' => 'text-cyan-600 bg-cyan-50 border-cyan-100',
    ];
    $colorClass = $colors[$color] ?? $colors['blue'];
@endphp

<div class="glass-card p-6 flex items-center justify-between group hover:border-slate-300 transition-all duration-300">
    <div class="space-y-1">
        <p class="text-[0.65rem] font-black uppercase tracking-[0.2em] text-slate-500">{{ $title }}</p>
        <div class="flex items-baseline gap-2">
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $value }}</h3>
            @if($description)
                <span class="text-[0.7rem] font-medium text-slate-400">{{ $description }}</span>
            @endif
        </div>
    </div>
    
    @if($icon)
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center border {{ $colorClass }} group-hover:scale-110 transition-transform duration-500">
            {!! $icon !!}
        </div>
    @endif
</div>
