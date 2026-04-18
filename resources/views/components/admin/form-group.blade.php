@props([
    'label' => null,
    'name' => null,
    'required' => false,
    'help' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <label for="{{ $name }}" class="text-sm font-bold text-slate-700 flex items-center gap-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        {{ $slot }}
    </div>

    @if($help)
        <p class="text-[0.7rem] text-slate-500 leading-relaxed">{{ $help }}</p>
    @endif

    @if($name)
        @error($name)
            <p class="text-xs font-bold text-red-600 animate-in fade-in slide-in-from-top-1">{{ $message }}</p>
        @enderror
    @endif
</div>
