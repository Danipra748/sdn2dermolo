@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - SD N 2 Dermolo')

@section('content')
<section class="pt-28 pb-12 px-4 relative overflow-hidden"
    @if (!empty($heroBg))
        style="background-image: url('{{ asset('storage/' . $heroBg) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
    @else
        style="background: linear-gradient(90deg, #4f46e5, #0ea5e9);"
    @endif>
    @if (!empty($heroBg))
        <div class="absolute inset-0 bg-slate-900/40"></div>
    @endif
    <div class="max-w-6xl mx-auto text-center text-white relative z-10">
        <h1 class="text-4xl md:text-5xl font-bold">Fasilitas Sekolah</h1>
        <p class="mt-3 text-white/80 max-w-2xl mx-auto">
            Fasilitas modern untuk mendukung proses belajar yang optimal.
        </p>
    </div>
</section>

@php
    $warnaDesign = [
        'blue'   => ['gradient' => 'from-blue-50 to-blue-100'],
        'green'  => ['gradient' => 'from-emerald-50 to-emerald-100'],
        'yellow' => ['gradient' => 'from-amber-50 to-amber-100'],
        'pink'   => ['gradient' => 'from-pink-50 to-pink-100'],
        'purple' => ['gradient' => 'from-purple-50 to-purple-100'],
        'orange' => ['gradient' => 'from-orange-50 to-orange-100'],
    ];

    $iconMap = [
        'Ruang Kelas' => '🏫',
        'Perpustakaan' => '📚',
        'Musholla' => '🕌',
        'Lapangan Olahraga' => '⚽',
        'Lab Komputer' => '💻',
        'Lab IPA' => '🔬',
        'Aula Serbaguna' => '🏛️',
        'Kantin Sehat' => '🍽️',
        'UKS' => '🧑‍⚕️',
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

        <div class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($fasilitas as $item)
                @php
                    $isObj = is_object($item);
                    $nama  = $isObj ? $item->nama : ($item['title'] ?? 'Fasilitas');
                    $desk  = $isObj ? $item->deskripsi : ($item['description'] ?? '');
                    $iconImg = $isObj ? ($item->icon_image ?? null) : ($item['icon_image'] ?? null);
                    $iconEmoji = $isObj ? ($item->icon ?? null) : ($item['icon'] ?? null);
                    $warna = $isObj ? ($item->warna ?? 'blue') : ($item['color'] ?? 'blue');
                    $fd = $warnaDesign[$warna] ?? $warnaDesign['blue'];
                    $emoji = $iconMap[$nama] ?? '🏫';
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-r {{ $fd['gradient'] }} flex items-center justify-center text-slate-700 text-xl">
                    @if ($nama === 'Ruang Kelas')
                        <span>🏫</span>
                    @elseif ($iconImg)
                        <img src="{{ asset('storage/' . $iconImg) }}" alt="{{ $nama }}" class="w-9 h-9 object-contain">
                    @elseif ($iconEmoji)
                        <span>{{ $iconEmoji }}</span>
                    @else
                        <span>{{ $emoji }}</span>
                    @endif
                </div>
                    <div>
                        <h3 class="font-semibold text-slate-900">{{ $nama }}</h3>
                        <p class="text-sm text-slate-600 mt-1">{{ $desk }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
