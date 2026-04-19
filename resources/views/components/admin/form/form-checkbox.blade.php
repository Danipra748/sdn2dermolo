@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'required' => false,
    'disabled' => false,
    'help' => null,
    'error' => null,
])

@php
    $error = $error ?? ($errors->has($name) ? $errors->first($name) : null);
@endphp

<div class="flex items-start gap-3">
    <div class="flex items-center h-6">
        <input 
            type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            value="1"
            @checked(old($name, $value))
            @if($disabled) disabled @endif
            @if($required) required @endif
            class="w-5 h-5 rounded-lg border-2 border-slate-300 text-blue-600 
                focus:ring-2 focus:ring-slate-400 focus:ring-offset-0
                disabled:opacity-50 disabled:cursor-not-allowed"
            {{ $attributes }}
        />
    </div>

    <div class="flex-1">
        @if($label)
            <label for="{{ $name }}" class="text-sm font-bold text-slate-900 cursor-pointer">
                {{ $label }}
                @if($required)
                    <span class="text-red-600">*</span>
                @endif
            </label>
        @endif

        @if($help && !$error)
            <p class="text-xs text-slate-500 mt-1">{{ $help }}</p>
        @endif

        @if($error)
            <p class="text-xs text-red-600 font-medium mt-1">{{ $error }}</p>
        @endif
    </div>
</div>
