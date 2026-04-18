@props([
    'headers' => [],
    'searchPlaceholder' => 'Cari data...',
    'id' => 'dataTable',
])

<div class="space-y-4" id="{{ $id }}-container">
    {{-- Table Toolbar --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative flex-1 max-w-sm">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            </div>
            <input type="text" 
                   id="{{ $id }}-search"
                   placeholder="{{ $searchPlaceholder }}"
                   class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
        </div>

        @if($filters ?? false)
            <div class="flex items-center gap-2">
                {{ $filters }}
            </div>
        @endif
    </div>

    {{-- Table Wrapper --}}
    <div class="glass-card overflow-hidden border-slate-200">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-sm text-left border-collapse" id="{{ $id }}">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        @foreach($headers as $header)
                            <th class="px-6 py-4 font-black text-slate-500 uppercase tracking-[0.1em] text-[0.65rem]">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        {{-- Empty Search Result --}}
        <div id="{{ $id }}-empty" class="hidden py-20 text-center animate-in fade-in zoom-in-95">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            </div>
            <h4 class="text-slate-900 font-bold">Hasil tidak ditemukan</h4>
            <p class="text-slate-500 text-xs mt-1">Coba kata kunci lain atau reset pencarian.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('{{ $id }}-search');
        const table = document.getElementById('{{ $id }}');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        const emptyState = document.getElementById('{{ $id }}-empty');

        searchInput.addEventListener('keyup', function() {
            const query = searchInput.value.toLowerCase();
            let foundCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const text = rows[i].textContent.toLowerCase();
                if (text.includes(query)) {
                    rows[i].style.display = "";
                    foundCount++;
                } else {
                    rows[i].style.display = "none";
                }
            }

            if (foundCount === 0) {
                table.style.display = "none";
                emptyState.classList.remove('hidden');
            } else {
                table.style.display = "";
                emptyState.classList.add('hidden');
            }
        });
    });
</script>
@endpush
