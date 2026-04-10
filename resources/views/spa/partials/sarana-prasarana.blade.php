{{-- Sarana Prasarana SPA Partial --}}

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> SARANA PRASARANA
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Sarana & Prasarana
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Fasilitas pendukung pendidikan yang lengkap dan nyaman untuk menunjang kreativitas siswa.
        </p>
    </div>
</section>

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Fasilitas Sekolah</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto text-sm md:text-base">
                Fasilitas pendukung pembelajaran yang nyaman dan lengkap.
            </p>
            <div class="w-16 h-1 bg-teal-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="facility-grid mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($fasilitas as $item)
                @php
                    $isObj = is_object($item);
                    $nama  = $isObj ? $item->nama : ($item['title'] ?? 'Fasilitas');
                    $desk  = $isObj ? $item->deskripsi : ($item['description'] ?? '');
                    $warna = $isObj ? ($item->warna ?? 'blue') : ($item['color'] ?? 'blue');
                    $cardBg = $isObj ? ($item->card_bg_image ?? null) : ($item['card_bg_image'] ?? null);
                    $foto = $isObj ? ($item->foto ?? null) : ($item['foto'] ?? null);
                    $bgImg = $cardBg ?: $foto;
                    
                    $warnaDesign = [
                        'blue'   => 'linear-gradient(135deg,#eff6ff,#dbeafe)',
                        'green'  => 'linear-gradient(135deg,#f0fdf4,#dcfce7)',
                        'yellow' => 'linear-gradient(135deg,#fffbeb,#fef3c7)',
                        'pink'   => 'linear-gradient(135deg,#fdf2f8,#fce7f3)',
                        'purple' => 'linear-gradient(135deg,#faf5ff,#ede9fe)',
                        'orange' => 'linear-gradient(135deg,#fff7ed,#ffedd5)',
                    ];
                    $bgStyle = $warnaDesign[$warna] ?? $warnaDesign['blue'];
                @endphp
                <button type="button"
                    class="facility-card block h-96 w-full overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white text-left cursor-pointer transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)]"
                    data-facility-card
                    data-title="{{ $nama }}"
                    data-desc="{{ $desk }}"
                    data-image="{{ $bgImg ? asset('storage/' . $bgImg) : '' }}">
                    <div class="flex h-full flex-col">
                    <div class="facility-media relative h-52 w-full shrink-0 overflow-hidden bg-slate-200" style="{{ $bgImg ? '' : 'background: ' . $bgStyle . ';' }}">
                        @if ($bgImg)
                            <img src="{{ asset('storage/' . $bgImg) }}" alt="{{ $nama }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="facility-body flex flex-1 flex-col gap-3 overflow-hidden px-5 py-5">
                        <div class="text-[0.72rem] font-bold uppercase tracking-[0.18em] text-teal-600">Fasilitas</div>
                        <div class="facility-card-title text-[1.02rem] font-bold leading-6 text-slate-900">{{ $nama }}</div>
                        <div class="facility-card-desc text-[0.9rem] leading-6 text-slate-500">{{ Str::limit($desk, 120) }}</div>
                        <div class="mt-auto pt-2 text-[0.78rem] font-semibold uppercase tracking-[0.12em] text-slate-400">Klik untuk detail</div>
                    </div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</section>

<div id="facility-modal" class="fixed inset-0 hidden items-center justify-center p-6 z-60" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-900/60" data-facility-close></div>
    <div class="relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true">
        <button type="button" class="absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-facility-close aria-label="Tutup">
            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="bg-slate-200 min-h-[300px]">
            <img id="facility-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="p-6">
            <h3 id="facility-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="facility-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>
