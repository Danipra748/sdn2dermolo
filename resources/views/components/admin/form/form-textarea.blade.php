@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'rows' => 4,
    'maxLength' => null,
    'required' => false,
    'disabled' => false,
    'placeholder' => null,
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

    <textarea 
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($maxLength) maxlength="{{ $maxLength }}" @endif
        @if($disabled) disabled @endif
        @if($required) required @endif
        class="w-full px-4 py-2.5 text-sm rounded-xl border-2 transition-colors font-sans
            @if($error) 
                border-red-300 bg-red-50 text-red-900 focus:ring-red-500 focus:border-red-500
            @else
                border-slate-200 bg-white focus:ring-slate-400 focus:border-slate-400
            @endif
            focus:outline-none focus:ring-2 disabled:opacity-50 disabled:cursor-not-allowed resize-none"
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>

    <div class="flex justify-between">
        @if($help && !$error)
            <p class="text-xs text-slate-500">{{ $help }}</p>
        @endif

        @if($maxLength)
            <p class="text-xs text-slate-500 ml-auto">
                <span x-text="(document.getElementById('{{ $name }}')?.value || '').length">0</span>
                / {{ $maxLength }}
            </p>
        @endif
    </div>

    @if($error)
        <p class="text-xs text-red-600 font-medium">{{ $error }}</p>
    @endif
</div>

@if($maxLength)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('{{ $name }}');
            if(textarea) {
                textarea.addEventListener('input', function() {
                    const counter = this.parentElement.querySelector('span');
                    if(counter) counter.textContent = this.value.length;
                });
            }
        });
    </script>
@endif
