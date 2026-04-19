@props([
    'title' => 'Confirm Action',
    'message' => 'Are you sure? This action cannot be undone.',
    'confirmText' => 'Delete',
    'cancelText' => 'Cancel',
    'confirmColor' => 'destructive',  // primary, destructive, warning
    'action' => null,
])

<div x-data="{ 
    open: false,
    init() {
        @if($attributes->has('@confirm'))
            window.addEventListener('confirm-action', (e) => {
                this.open = true;
            });
        @endif
    }
}"
x-show="open"
class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
style="display: none;">

    <div class="bg-white rounded-2xl shadow-lg max-w-md w-full mx-4 animate-in zoom-in">
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $title }}</h3>
            <p class="text-sm text-slate-600">{{ $message }}</p>
        </div>

        <div class="border-t border-slate-200 p-6 flex gap-3 justify-end">
            <button @click="open = false"
                type="button"
                class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-sm font-bold
                    hover:bg-slate-50 transition-colors">
                {{ $cancelText }}
            </button>

            @php
                $confirmClasses = [
                    'primary' => 'bg-slate-900 text-white hover:bg-slate-800',
                    'destructive' => 'bg-red-600 text-white hover:bg-red-700',
                    'warning' => 'bg-amber-600 text-white hover:bg-amber-700',
                ];
            @endphp

            <form @if($action) action="{{ $action }}" method="POST" @endif class="inline">
                @csrf
                @method('DELETE')
                <button @click="open = false"
                    type="submit"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-colors
                        {{ $confirmClasses[$confirmColor] ?? $confirmClasses['destructive'] }}">
                    {{ $confirmText }}
                </button>
            </form>
        </div>
    </div>
</div>
