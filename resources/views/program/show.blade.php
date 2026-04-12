@extends('layouts.app')

@section('title', $data['title'].' - SD N 2 Dermolo')

@push('styles')
<style>
    .photo-modal { position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 1.5rem; z-index: 70; }
    .photo-modal.is-open { display: flex; }
    .photo-modal-backdrop { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.85); }
    .photo-modal-content {
        position: relative;
        max-width: 1000px;
        width: 100%;
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    }
    .photo-modal-image {
        width: 100%;
        max-height: 70vh;
        object-fit: contain;
        background: #f1f5f9;
    }
    .photo-modal-caption {
        padding: 1rem 1.5rem;
        text-align: center;
        font-size: 0.95rem;
        color: #475569;
        background: white;
    }
    .photo-modal-close {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 40px;
        height: 40px;
        border-radius: 9999px;
        background: white;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
    }
    .photo-modal-close:hover {
        background: #f8fafc;
        transform: scale(1.05);
    }
    .gallery-image-wrapper {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .gallery-image-wrapper:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    .gallery-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .gallery-image-wrapper:hover img {
        transform: scale(1.05);
    }
    .gallery-image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 1rem;
    }
    .gallery-image-wrapper:hover .gallery-image-overlay {
        opacity: 1;
    }
    .gallery-image-overlay-text {
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@section('content')
<section class="pt-32 pb-16 px-4 bg-gradient-to-r {{ $data['hero_color'] }} relative overflow-hidden"
    @if (!empty($data['card_bg_image']))
        style="background-image: url('{{ asset('storage/' . $data['card_bg_image']) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
    @endif>
    @if (!empty($data['card_bg_image']))
        <div class="absolute inset-0 bg-slate-900/45"></div>
    @endif
    <div class="mx-auto max-w-[1200px] px-6 py-20 text-center relative z-10">
        <h1 class="font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white mb-4 drop-shadow-lg">
            {{ $data['title'] }}
        </h1>
        <p class="text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85 max-w-[700px] mx-auto text-center">
            {{ $data['subtitle'] }}
        </p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('program.index') }}"
               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                <- Kembali ke Program
            </a>
        </div>

        @php
            // Check if this program should hide the description section
            // Programs without description: Pramuka, Drumband, Seni Ukir
            $titlesWithoutDesc = ['Ekstra Pramuka', 'Drumband', 'Seni Ukir'];
            $hideDescription = in_array($data['title'], $titlesWithoutDesc);
        @endphp

        @if (!$hideDescription)
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-10 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Deskripsi Program</h2>
            <p class="text-slate-600 leading-relaxed mb-4">
                Halaman ini menampilkan dokumentasi lengkap kegiatan program {{ $data['title'] }}.
            </p>
            <div class="grid md:grid-cols-3 gap-4 mt-6">
                @foreach ($data['highlights'] as $point)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">{{ $point }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-dashed border-slate-300">
            <h3 class="text-xl font-semibold text-slate-900 mb-3">Galeri Foto Kegiatan</h3>
            <p class="text-slate-600 mb-6">Dokumentasi momen penting dan aktivitas kegiatan program. Klik pada foto untuk memperbesar.</p>
            
            @if (!empty($data['photos']) && count($data['photos']) > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($data['photos'] as $index => $photo)
                        <div class="group">
                            <div class="gallery-image-wrapper"
                                 data-photo-index="{{ $index }}"
                                 data-photo-caption="{{ $photo['caption'] ?: 'Dokumentasi kegiatan ' . $data['title'] }}">
                                <img src="{{ asset('storage/' . $photo['photo']) }}"
                                     alt="Dokumentasi {{ $data['title'] }}"
                                     loading="lazy">
                                <div class="gallery-image-overlay">
                                    <span class="gallery-image-overlay-text"><i class="fas fa-search-plus"></i> Klik untuk memperbesar</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed line-clamp-2">
                                {{ $photo['caption'] ?: 'Dokumentasi kegiatan ' . $data['title'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Placeholder untuk foto yang akan ditambahkan --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="group">
                            <div class="gallery-image-wrapper bg-slate-100 border border-slate-200 flex items-center justify-center"
                                 style="cursor: default;">
                                <div class="text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs">Foto {{ $i }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2 text-center">Akan ditambahkan</p>
                        </div>
                    @endfor
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ===== BACK TO HOME BUTTON ===== --}}
<section class="py-12 px-4 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl">
            <x-heroicon-o-arrow-left class="w-5 h-5" />
            Kembali ke Beranda
        </a>
    </div>
</section>

{{-- Photo Modal --}}
<div id="photo-modal" class="photo-modal" aria-hidden="true">
    <div class="photo-modal-backdrop" data-photo-close></div>
    <div class="photo-modal-content" role="dialog" aria-modal="true" aria-labelledby="photo-modal-caption">
        <button type="button" class="photo-modal-close" data-photo-close aria-label="Tutup">
            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="photo-modal-image" class="photo-modal-image" alt="" />
        <div id="photo-modal-caption" class="photo-modal-caption"></div>
    </div>
</div>

@push('scripts')
<script>
(() => {
    const modal = document.getElementById('photo-modal');
    if (!modal) return;
    
    const imageEl = document.getElementById('photo-modal-image');
    const captionEl = document.getElementById('photo-modal-caption');
    const photoCards = document.querySelectorAll('[data-photo-index]');
    
    if (photoCards.length === 0) return;
    
    // Array to store photo data
    const photos = [];
    photoCards.forEach(card => {
        const img = card.querySelector('img');
        if (img) {
            photos.push({
                src: img.src,
                caption: card.dataset.photoCaption || ''
            });
        }
    });
    
    const openModal = (index) => {
        const photo = photos[index];
        if (!photo) return;
        
        imageEl.src = photo.src;
        imageEl.alt = photo.caption;
        captionEl.textContent = photo.caption;
        
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };
    
    const closeModal = () => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        imageEl.removeAttribute('src');
    };
    
    // Open modal on card click
    photoCards.forEach((card) => {
        card.addEventListener('click', (e) => {
            e.preventDefault();
            const index = parseInt(card.dataset.photoIndex);
            openModal(index);
        });
    });
    
    // Close modal
    modal.querySelectorAll('[data-photo-close]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });
    
    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
    
    // Close on backdrop click (outside content)
    modal.querySelector('.photo-modal-backdrop').addEventListener('click', closeModal);
})();
</script>
@endpush
@endsection
