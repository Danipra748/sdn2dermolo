@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Fasilitas Sekolah - SD N 2 Dermolo')

@push('styles')
<style>
    /* Modal styles - required for JS interaction */
    .facility-modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 1.5rem; z-index: 60; }
    .facility-modal.is-open { display: flex; }
</style>
@endpush

@section('content')
<section class="min-h-[600px] pt-32 pb-16 px-4 relative overflow-hidden"
    @if (!empty($heroBg))
        style="background-image: url('{{ asset('storage/' . $heroBg) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
    @else
        style="background: linear-gradient(90deg, #4f46e5, #0ea5e9);"
    @endif>
    @if (!empty($heroBg))
        <div class="absolute inset-0 bg-slate-900/40"></div>
    @endif
    <div class="max-w-7xl mx-auto text-center text-white relative z-10">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Fasilitas Sekolah</h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto">
            Fasilitas modern untuk mendukung proses belajar yang optimal.
        </p>
    </div>
</section>

@php
    $warnaDesign = [
        'blue'   => 'linear-gradient(135deg,#eff6ff,#dbeafe)',
        'green'  => 'linear-gradient(135deg,#f0fdf4,#dcfce7)',
        'yellow' => 'linear-gradient(135deg,#fffbeb,#fef3c7)',
        'pink'   => 'linear-gradient(135deg,#fdf2f8,#fce7f3)',
        'purple' => 'linear-gradient(135deg,#faf5ff,#ede9fe)',
        'orange' => 'linear-gradient(135deg,#fff7ed,#ffedd5)',
    ];
@endphp

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Fasilitas Sekolah</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto text-sm md:text-base">
                Fasilitas pendukung pembelajaran yang nyaman dan lengkap.
            </p>
            <div class="w-16 h-1 bg-teal-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="facility-grid grid grid-cols-[repeat(auto-fit,minmax(240px,1fr))] gap-6 mt-10">
            @foreach ($fasilitas as $item)
                @php
                    $isObj = is_object($item);
                    $nama  = $isObj ? $item->nama : ($item['title'] ?? 'Fasilitas');
                    $desk  = $isObj ? $item->deskripsi : ($item['description'] ?? '');
                    $warna = $isObj ? ($item->warna ?? 'blue') : ($item['color'] ?? 'blue');
                    $cardBg = $isObj ? ($item->card_bg_image ?? null) : ($item['card_bg_image'] ?? null);
                    $foto = $isObj ? ($item->foto ?? null) : ($item['foto'] ?? null);
                    $bgImg = $cardBg ?: $foto;
                    $bgStyle = $warnaDesign[$warna] ?? $warnaDesign['blue'];
                @endphp
                <button type="button"
                    class="facility-card bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden text-left cursor-pointer transition-all duration-[350ms] hover:-translate-y-[6px] hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)] hover:border-transparent block w-full"
                    data-facility-card
                    data-title="{{ $nama }}"
                    data-desc="{{ $desk }}"
                    data-image="{{ $bgImg ? asset('storage/' . $bgImg) : '' }}">
                    <div class="facility-media relative aspect-[16/9] bg-slate-200 overflow-hidden" style="{{ $bgImg ? '' : 'background: ' . $bgStyle . ';' }}">
                        @if ($bgImg)
                            <img src="{{ asset('storage/' . $bgImg) }}" alt="{{ $nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <x-heroicon-o-photo class="w-10 h-10 text-slate-400" />
                            </div>
                        @endif
                        <div class="facility-title absolute left-0 right-0 bottom-0 px-4 py-[0.9rem] font-bold text-white" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.7) 100%);">{{ $nama }}</div>
                    </div>
                    <div class="facility-body px-4 py-[1rem] pb-[1.2rem] text-slate-500 text-[0.9rem] leading-[1.6]">{{ Str::limit($desk, 120) }}</div>
                </button>
            @endforeach
        </div>
    </div>
</section>

<div id="facility-modal" class="facility-modal" aria-hidden="true">
    <div class="facility-modal-backdrop absolute inset-0 bg-slate-900/60" data-facility-close></div>
    <div class="facility-modal-content relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true" aria-labelledby="facility-modal-title">
        <button type="button" class="facility-modal-close absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-facility-close aria-label="Tutup">
            <x-heroicon-o-x-mark class="w-5 h-5 text-slate-700" />
        </button>
        <div class="facility-modal-media bg-slate-200">
            <img id="facility-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="facility-modal-body p-6">
            <h3 id="facility-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="facility-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const modal = document.getElementById('facility-modal');
    if (!modal) return;
    const imageEl = document.getElementById('facility-modal-image');
    const titleEl = document.getElementById('facility-modal-title');
    const descEl  = document.getElementById('facility-modal-desc');

    const openModal = (card) => {
        const title = card.dataset.title || '';
        const desc  = card.dataset.desc || '';
        const img   = card.dataset.image || '';
        titleEl.textContent = title;
        descEl.textContent = desc || 'Deskripsi fasilitas belum tersedia.';
        if (img) {
            imageEl.src = img;
            imageEl.style.display = 'block';
        } else {
            imageEl.removeAttribute('src');
            imageEl.style.display = 'none';
        }
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    document.querySelectorAll('[data-facility-card]').forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });
    modal.querySelectorAll('[data-facility-close]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
@endpush
