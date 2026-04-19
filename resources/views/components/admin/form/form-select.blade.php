@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'options' => [],
    'multiple' => false,
    'required' => false,
    'disabled' => false,
    'placeholder' => 'Select an option...',
    'help' => null,
    'error' => null,
])

@php
    $error = $error ?? ($errors->has($name) ? $errors->first($name) : null);
@endphp

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-bold text-slate-900">
            {{ $label }}
            @if($required)
                <span class="text-red-600">*</span>
            @endif
        </label>
    @endif

    <select 
        id="{{ $name }}"
        name="{{ $multiple ? $name . '[]' : $name }}"
        @if($multiple) multiple @endif
        @if($disabled) disabled @endif
        @if($required) required @endif
        class="w-full px-4 py-2.5 text-sm rounded-xl border-2 transition-colors
            @if($error) 
                border-red-300 bg-red-50 text-red-900 focus:ring-red-500 focus:border-red-500
            @else
                border-slate-200 bg-white focus:ring-slate-400 focus:border-slate-400
            @endif
            focus:outline-none focus:ring-2 disabled:opacity-50 disabled:cursor-not-allowed"
        {{ $attributes }}
    >
        @unless($multiple)
            <option value="">{{ $placeholder }}</option>
        @endunless

        @foreach($options as $optionValue => $optionLabel)
            <option 
                value="{{ $optionValue }}"
                @if(is_array(old($name, $value)))
                    @selected(in_array($optionValue, old($name, $value ?? [])))
                @else
                    @selected(old($name, $value) == $optionValue)
                @endif
            >
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if($help && !$error)
        <p class="text-xs text-slate-500">{{ $help }}</p>
    @endif

    @if($error)
        <p class="text-xs text-red-600 font-medium">{{ $error }}</p>
    @endif
</div>
