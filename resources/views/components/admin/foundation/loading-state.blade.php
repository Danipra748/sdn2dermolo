@props([
    'variant' => 'spinner',  // spinner, skeleton
    'text' => 'Loading...',
])

@if($variant === 'spinner')
    <div class="flex flex-col items-center justify-center gap-4 py-12">
        <div class="relative w-12 h-12">
            <div class="absolute inset-0 rounded-full border-4 border-slate-200"></div>
            <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-slate-900 animate-spin"></div>
        </div>
        @if($text)
            <p class="text-sm text-slate-500">{{ $text }}</p>
        @endif
    </div>
@elseif($variant === 'skeleton')
    <div class="space-y-4">
        <div class="h-4 bg-slate-200 rounded-lg animate-pulse"></div>
        <div class="h-4 bg-slate-200 rounded-lg animate-pulse w-5/6"></div>
        <div class="h-4 bg-slate-200 rounded-lg animate-pulse w-4/6"></div>
        <div class="mt-6 space-y-3">
            <div class="h-3 bg-slate-200 rounded-lg animate-pulse"></div>
            <div class="h-3 bg-slate-200 rounded-lg animate-pulse"></div>
        </div>
    </div>
@endif
