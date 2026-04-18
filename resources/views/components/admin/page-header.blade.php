@props([
    'title',
    'subtitle' => null,
    'icon' => null,
])

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-4">
        @if($icon)
            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-900">
                {!! $icon !!}
            </div>
        @endif
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-sm text-slate-500 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if($actions ?? false)
        <div class="flex items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
