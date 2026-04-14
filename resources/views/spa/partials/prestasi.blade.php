{{-- Prestasi SPA Partial --}}

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg> PRESTASI SISWA
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Prestasi Siswa
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Catatan kebanggaan dan pencapaian luar biasa yang diraih oleh siswa-siswi terbaik kami.
        </p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
            @forelse ($prestasi as $item)
                <button type="button"
                    class="prestasi-card group w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm text-left cursor-pointer transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-[6px] hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)] hover:border-slate-300"
                    data-prestasi-card
                    data-title="{{ $item->judul ?? '' }}"
                    data-desc="{{ $item->deskripsi ?? '' }}"
                    data-image="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}">
                    @if ($item->foto)
                        <div class="aspect-[4/3] w-full overflow-hidden bg-slate-50">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}"
                                 class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="aspect-[4/3] w-full bg-gradient-to-br from-purple-500 to-purple-700">
                            <div class="flex h-full items-center justify-center text-white">
                                <svg class="w-14 h-14 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            </div>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="mb-2 line-clamp-2 text-[0.95rem] font-bold leading-snug text-slate-900">{{ \Illuminate\Support\Str::limit($item->judul, 56) }}</h3>
                        @if ($item->deskripsi)
                            <p class="line-clamp-3 text-[0.8rem] leading-5 text-slate-600">{{ \Illuminate\Support\Str::limit($item->deskripsi, 88) }}</p>
                        @endif
                        <div class="mt-3 pt-2 border-t border-slate-100 text-[0.72rem] font-semibold uppercase tracking-[0.1em] text-purple-600">
                            Klik untuk detail
                        </div>
                    </div>
                </button>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-2xl border border-slate-200 p-12">
                        <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <p class="text-slate-500 text-lg font-semibold">Belum ada prestasi yang dicatat</p>
                        <p class="text-slate-400 text-sm mt-2">Prestasi akan ditampilkan di sini setelah ditambahkan</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Prestasi Modal --}}
<div id="prestasi-modal" class="fixed inset-0 hidden items-center justify-center p-6 z-[60]" aria-hidden="true">
    <div class="prestasi-modal-backdrop absolute inset-0 bg-slate-900/60" data-prestasi-close></div>
    <div class="prestasi-modal-content relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true" aria-labelledby="prestasi-modal-title">
        <button type="button" class="prestasi-modal-close absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-prestasi-close aria-label="Tutup">
            <x-heroicon-o-x-mark class="w-5 h-5 text-slate-700" />
        </button>
        <div class="prestasi-modal-media bg-slate-200 min-h-[300px]">
            <img id="prestasi-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="prestasi-modal-body p-6">
            <h3 id="prestasi-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="prestasi-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>
<div class="flex flex-wrap gap-4 justify-center mb-16">
    <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full  text-blue-600 font-bold hover:bg-blue-50 transition shadow-2xl hover:shadow-3xl text-lg">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
    </a>
</div>

