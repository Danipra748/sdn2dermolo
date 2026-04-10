@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Program Sekolah - SD N 2 Dermolo')

@section('content')
<section class="relative overflow-hidden text-white" style="padding-top: 100px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-20 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <x-heroicon-o-academic-cap class="h-4 w-4" /> PROGRAM MINAT BAKAT
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Ekstrakurikuler
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Pilihan kegiatan untuk mengembangkan bakat, minat, dan karakter siswa di luar jam pelajaran.
        </p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($program as $item)
                @php
                    $isObj = is_object($item);
                    $title = $isObj ? $item->title : ($item['title'] ?? 'Program');
                    $desc  = $isObj ? $item->desc  : ($item['desc'] ?? '');
                    $logo  = $isObj ? ($item->logo ?? null) : null;
                    $foto  = $isObj ? ($item->foto ?? null) : ($item['foto'] ?? null);
                    $emoji = $isObj ? ($item->emoji ?? null) : ($item['emoji'] ?? null);
                    $cardBg = $isObj ? ($item->card_bg_image ?? null) : ($item['card_bg_image'] ?? null);
                    $slug  = $isObj ? ($item->slug ?? null) : null;
                    $routeName = $isObj ? ($slug ? 'program.' . $slug : null) : ($item['route'] ?? null);
                    $link = $routeName ? route($routeName) : '#';

                    $colorKey = $isObj
                        ? match ($slug) { 'pramuka' => 'blue', 'seni-ukir' => 'green', 'drumband' => 'yellow', default => 'blue' }
                        : ($item['color'] ?? 'blue');
                    $gradients = [
                        'blue' => 'linear-gradient(135deg,#1a56db,#3b82f6)',
                        'green' => 'linear-gradient(135deg,#059669,#34d399)',
                        'yellow' => 'linear-gradient(135deg,#d97706,#fbbf24)',
                    ];
                    $gradient = $gradients[$colorKey] ?? $gradients['blue'];
                    $bgStyle = !empty($cardBg)
                        ? "background-image: url('" . asset('storage/' . $cardBg) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                        : '';
                @endphp
                <a href="{{ $link }}"
                    id="program-card-{{ $slug ?? Str::slug($title) }}"
                    class="program-card group block w-full overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-sm cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="flex flex-col h-full">
                        <div class="program-media relative w-full overflow-hidden bg-slate-200"
                             style="{{ $bgStyle ?: 'background: ' . $gradient . ';' }}">
                            <div class="aspect-video w-full">
                                @if (empty($cardBg))
                                    @if (!empty($logo))
                                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo {{ $title }}"
                                             class="h-full w-full object-cover">
                                    @elseif (!empty($foto))
                                        <img src="{{ asset('storage/' . $foto) }}" alt="{{ $title }}"
                                             class="h-full w-full object-cover">
                                    @elseif (!empty($emoji))
                                        <div class="flex h-full w-full items-center justify-center">
                                            <span class="text-6xl text-white/80 font-bold">{{ $emoji }}</span>
                                        </div>
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <span class="text-6xl text-white/80 font-bold">{{ strtoupper(substr($title, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="program-body flex flex-1 flex-col px-5 py-5">
                            <div class="text-[0.7rem] font-bold uppercase tracking-[0.15em] text-blue-600">Ekstrakurikuler</div>
                            <div class="program-card-title text-[1rem] font-bold leading-snug text-slate-900">{{ $title }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
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
@endsection
