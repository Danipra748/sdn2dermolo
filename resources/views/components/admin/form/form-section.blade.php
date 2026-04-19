@props([
    'title' => null,
    'description' => null,
    'contentClass' => '',
])

<div @if($attributes->has('x-data')) {{ $attributes }} @endif>
    @if($title)
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-900">{{ $title }}</h3>
            @if($description)
                <p class="text-sm text-slate-500 mt-1">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="space-y-4 {{ $contentClass }}">
        {{ $slot }}
    </div>
</div>
