@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Galeri Sekolah - SD N 2 Dermolo')

@push('styles')
<style>
    .gallery-modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 1.5rem; z-index: 60; }
    .gallery-modal.is-open { display: flex; }
    .gallery-card-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .gallery-card-desc {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<section class="relative overflow-hidden text-white" style="padding-top: 100px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-20 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <x-heroicon-o-camera class="h-4 w-4" /> GALERI SEKOLAH
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Galeri Sekolah
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Dokumentasi kegiatan dan momen berharga di SD N 2 Dermolo.
        </p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                ← Kembali ke Beranda
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-dashed border-slate-300">
            <h3 class="text-xl font-semibold text-slate-900 mb-3">Dokumentasi Kegiatan</h3>
            <p class="text-slate-600 mb-6">Foto-foto kegiatan dan momen penting di lingkungan sekolah kami.</p>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
                @forelse ($galleries as $gallery)
                    <button type="button"
                        id="gallery-card-{{ $gallery->id }}"
                        class="gallery-card block h-96 w-full overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white text-left cursor-pointer transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)]"
                        data-gallery-card
                        data-title="{{ $gallery->judul ?? '' }}"
                        data-desc="{{ $gallery->deskripsi ?? '' }}"
                        data-image="{{ !empty($gallery->foto) ? asset('storage/' . $gallery->foto) : '' }}">
                        <div class="flex h-full flex-col">
                            <div class="gallery-media relative h-52 w-full shrink-0 overflow-hidden bg-slate-200">
                                @if (!empty($gallery->foto))
                                    <img src="{{ asset('storage/' . $gallery->foto) }}" alt="{{ $gallery->judul }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-500 to-blue-700">
                                        <x-heroicon-o-camera class="w-12 h-12 text-white/50" />
                                    </div>
                                @endif
                            </div>
                            <div class="gallery-body flex flex-1 flex-col gap-3 overflow-hidden px-5 py-5">
                                <div class="text-[0.72rem] font-bold uppercase tracking-[0.18em] text-blue-600">Galeri</div>
                                <div class="gallery-card-title text-[1.02rem] font-bold leading-6 text-slate-900">{{ $gallery->judul ?? '' }}</div>
                                <div class="mt-auto pt-2 text-[0.78rem] font-semibold uppercase tracking-[0.12em] text-slate-400">Klik untuk detail</div>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full flex h-[200px] items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500">
                        Belum ada dokumentasi galeri.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Gallery Modal --}}
<div id="gallery-modal" class="gallery-modal" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-900/60" data-gallery-close></div>
    <div class="relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title">
        <button type="button" class="absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-gallery-close aria-label="Tutup">
            <x-heroicon-o-x-mark class="w-5 h-5 text-slate-700" />
        </button>
        <div class="bg-slate-200 min-h-[300px]">
            <img id="gallery-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="p-6">
            <h3 id="gallery-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="gallery-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
(() => {
    const modal = document.getElementById('gallery-modal');
    if (!modal) return;
    const imageEl = document.getElementById('gallery-modal-image');
    const titleEl = document.getElementById('gallery-modal-title');
    const descEl  = document.getElementById('gallery-modal-desc');

    const openModal = (card) => {
        const title = card.dataset.title || '';
        const desc  = card.dataset.desc || '';
        const img   = card.dataset.image || '';
        titleEl.textContent = title;
        descEl.textContent = desc || 'Deskripsi belum tersedia.';
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

    document.querySelectorAll('[data-gallery-card]').forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });
    modal.querySelectorAll('[data-gallery-close]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
@endpush
@endsection
