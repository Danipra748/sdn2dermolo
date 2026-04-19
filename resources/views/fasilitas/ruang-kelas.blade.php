@extends('layouts.app')

@section('title', 'Ruang Kelas - SD N 2 Dermolo')

@section('content')
{{-- Hero Section --}}
<section class="page-hero relative overflow-hidden text-white" style="@if (!empty($data['card_bg_image'])) background-image: url('{{ asset('storage/' . $data['card_bg_image']) }}'); background-size: cover; background-position: center; @else background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%); @endif">
    @if (!empty($data['card_bg_image']))
        <div class="absolute inset-0 bg-slate-900/40"></div>
    @endif
    <div class="relative z-10 mx-auto max-w-[1200px] px-6 py-16 md:py-20 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <x-heroicon-o-building-office class="h-4 w-4" /> FASILITAS
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            {{ $data['title'] }}
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            {{ $data['subtitle'] }}
        </p>
    </div>
</section>

{{-- Description Section --}}
<section class="py-12 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">{{ $data['description_title'] }}</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="max-w-4xl mx-auto space-y-4">
            @foreach ($data['description_paragraphs'] as $paragraph)
                <p class="text-slate-600 text-lg leading-relaxed text-center">{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">{{ $data['stats_title'] }}</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($data['stats'] as $stat)
                @php
                    $colorMap = [
                        'blue' => 'bg-blue-100 text-blue-600',
                        'green' => 'bg-green-100 text-green-600',
                        'purple' => 'bg-purple-100 text-purple-600',
                        'orange' => 'bg-orange-100 text-orange-600',
                    ];
                    $colorClass = $colorMap[$stat['color']] ?? 'bg-blue-100 text-blue-600';
                @endphp
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="text-3xl mb-2">{{ $stat['icon'] }}</div>
                    <div class="text-2xl font-bold text-slate-900 mb-1">{{ $stat['value'] }}</div>
                    <div class="text-sm text-slate-600">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Kelas Section --}}
<section class="py-12 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">{{ $data['kelas_title'] }}</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($data['kelas'] as $kelasItem)
                @php
                    $borderColors = [
                        'red' => 'border-red-500',
                        'orange' => 'border-orange-500',
                        'yellow' => 'border-yellow-500',
                        'green' => 'border-green-500',
                        'blue' => 'border-blue-500',
                        'purple' => 'border-purple-500',
                    ];
                    $borderColor = $borderColors[$kelasItem['color']] ?? 'border-blue-500';
                @endphp
                <div class="bg-white rounded-xl border-l-4 {{ $borderColor }} shadow-sm p-6">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">{{ $kelasItem['level'] }}</h3>
                    <ul class="space-y-2">
                        @foreach ($kelasItem['rooms'] as $room)
                            <li class="text-slate-600 text-sm flex items-start gap-2">
                                <span class="text-blue-600 mt-1">•</span>
                                <span>{{ $room }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Fasilitas Section --}}
<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">{{ $data['fasilitas_title'] }}</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($data['fasilitas_items'] as $fasilitasItem)
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-3xl mb-3">{{ $fasilitasItem['icon'] }}</div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $fasilitasItem['title'] }}</h3>
                    <p class="text-slate-600">{{ $fasilitasItem['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Tata Tertib Section --}}
<section class="py-12 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-900">{{ $data['rules_title'] }}</h2>
            <div class="w-16 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center gap-2">
                    <span>✓</span> Yang Boleh Dilakukan
                </h3>
                <ul class="space-y-3">
                    @foreach ($data['tata_tertib_boleh'] as $rule)
                        <li class="flex items-start gap-3 text-slate-700">
                            <span class="text-green-600 font-bold mt-1">✓</span>
                            <span>{{ $rule }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold text-red-700 mb-4 flex items-center gap-2">
                    <span>✗</span> Yang Dilarang
                </h3>
                <ul class="space-y-3">
                    @foreach ($data['tata_tertib_larang'] as $rule)
                        <li class="flex items-start gap-3 text-slate-700">
                            <span class="text-red-600 font-bold mt-1">✗</span>
                            <span>{{ $rule }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-16 px-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-3">{{ $data['cta_title'] }}</h2>
        <p class="text-xl text-white/80 mb-8">{{ $data['cta_subtitle'] }}</p>
        <a href="{{ route('public.fasilitas.index') }}" 
           class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-blue-50 transition shadow-lg">
            <x-heroicon-o-arrow-left class="w-5 h-5" />
            {{ $data['back_button_text'] }}
        </a>
    </div>
</section>
@endsection
