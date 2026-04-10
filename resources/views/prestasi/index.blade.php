@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Prestasi Sekolah - SD N 2 Dermolo')

@push('styles')
<style>
    .prestasi-modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 1.5rem; z-index: 60; }
    .prestasi-modal.is-open { display: flex; }
    .prestasi-card-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .prestasi-card-desc {
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
            <x-heroicon-o-trophy class="h-4 w-4" /> PRESTASI SISWA
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
        <div class="mb-8">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-800 font-semibold transition">
                <- Kembali ke Beranda
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-dashed border-slate-300">
            <h3 class="text-xl font-semibold text-slate-900 mb-3">Area Dokumentasi Prestasi</h3>
            <p class="text-slate-600 mb-6">Foto dokumentasi ini diambil dari data Prestasi Sekolah di panel admin.</p>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
                @forelse ($data['dokumentasi'] as $dok)
                    <button type="button"
                        id="prestasi-card-{{ $dok['id'] ?? '' }}"
                        class="prestasi-card block h-96 w-full overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white text-left cursor-pointer transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)]"
                        data-prestasi-card
                        data-title="{{ $dok['judul'] ?? '' }}"
                        data-desc="{{ $dok['deskripsi'] ?? '' }}"
                        data-image="{{ !empty($dok['foto']) ? asset('storage/' . $dok['foto']) : '' }}">
                        <div class="flex h-full flex-col">
                            <div class="prestasi-media relative h-52 w-full shrink-0 overflow-hidden bg-slate-200">
                                @if (!empty($dok['foto']))
                                    <img src="{{ asset('storage/' . $dok['foto']) }}" alt="{{ $dok['judul'] }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-purple-500 to-purple-700">
                                        <x-heroicon-o-trophy class="w-12 h-12 text-white/50" />
                                    </div>
                                @endif
                            </div>
                            <div class="prestasi-body flex flex-1 flex-col gap-3 overflow-hidden px-5 py-5">
                                <div class="text-[0.72rem] font-bold uppercase tracking-[0.18em] text-purple-600">Prestasi</div>
                                <div class="prestasi-card-title text-[1.02rem] font-bold leading-6 text-slate-900">{{ $dok['judul'] ?? '' }}</div>
                                <div class="mt-auto pt-2 text-[0.78rem] font-semibold uppercase tracking-[0.12em] text-slate-400">Klik untuk detail</div>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full flex h-[200px] items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500">
                        Belum ada dokumentasi prestasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Prestasi Modal --}}
<div id="prestasi-modal" class="prestasi-modal" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-900/60" data-prestasi-close></div>
    <div class="relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true" aria-labelledby="prestasi-modal-title">
        <button type="button" class="absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-prestasi-close aria-label="Tutup">
            <x-heroicon-o-x-mark class="w-5 h-5 text-slate-700" />
        </button>
        <div class="bg-slate-200 min-h-[300px]">
            <img id="prestasi-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="p-6">
            <h3 id="prestasi-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="prestasi-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
(() => {
    const modal = document.getElementById('prestasi-modal');
    if (!modal) return;
    const imageEl = document.getElementById('prestasi-modal-image');
    const titleEl = document.getElementById('prestasi-modal-title');
    const descEl  = document.getElementById('prestasi-modal-desc');

    const openModal = (card) => {
        const title = card.dataset.title || '';
        const desc  = card.dataset.desc || '';
        const img   = card.dataset.image || '';
        titleEl.textContent = title;
        descEl.textContent = desc || 'Deskripsi prestasi belum tersedia.';
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

    document.querySelectorAll('[data-prestasi-card]').forEach(card => {
        card.addEventListener('click', () => openModal(card));
    });
    modal.querySelectorAll('[data-prestasi-close]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
@endpush
@endsection
