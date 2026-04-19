@props([
    'label' => null,
    'name' => null,
    'required' => false,
    'disabled' => false,
    'accept' => 'image/*',
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

    <div class="relative">
        <input 
            type="file"
            id="{{ $name }}"
            name="{{ $name }}"
            accept="{{ $accept }}"
            @if($disabled) disabled @endif
            @if($required) required @endif
            class="hidden"
            {{ $attributes }}
        />

        <label for="{{ $name }}" 
            class="flex flex-col items-center justify-center min-h-40 rounded-2xl border-2 border-dashed cursor-pointer transition-colors
            @if($error)
                border-red-300 bg-red-50 hover:bg-red-100
            @else
                border-slate-300 bg-slate-50 hover:bg-slate-100
            @endif">
            
            <div class="text-center">
                <svg class="w-10 h-10 mx-auto mb-2 @if($error) text-red-400 @else text-slate-400 @endif" 
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4v16m8-8H4"/>
                </svg>
                <p class="text-sm font-bold @if($error) text-red-700 @else text-slate-700 @endif">
                    Drop file here or click to browse
                </p>
                <p class="text-xs @if($error) text-red-600 @else text-slate-500 @endif mt-1">
                    {{ str_replace('image/', '', $accept) }}
                </p>
            </div>
        </label>

        <div class="mt-2" id="{{ $name }}-preview"></div>
    </div>

    @if($help && !$error)
        <p class="text-xs text-slate-500">{{ $help }}</p>
    @endif

    @if($error)
        <p class="text-xs text-red-600 font-medium">{{ $error }}</p>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('{{ $name }}');
        const preview = document.getElementById('{{ $name }}-preview');
        const label = input.parentElement.querySelector('label');

        function handleFiles(files) {
            if(files.length === 0) return;
            const file = files[0];
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <div class="relative bg-white rounded-xl border border-slate-200 p-3 overflow-hidden">
                        <img src="${e.target.result}" class="w-full h-48 object-cover rounded-lg mb-2">
                        <p class="text-xs text-slate-600">${file.name}</p>
                        <p class="text-xs text-slate-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }

        input.addEventListener('change', (e) => handleFiles(e.target.files));

        label.addEventListener('dragover', (e) => {
            e.preventDefault();
            label.classList.add('bg-slate-200');
        });

        label.addEventListener('dragleave', () => {
            label.classList.remove('bg-slate-200');
        });

        label.addEventListener('drop', (e) => {
            e.preventDefault();
            label.classList.remove('bg-slate-200');
            input.files = e.dataTransfer.files;
            handleFiles(e.dataTransfer.files);
        });
    });
</script>
