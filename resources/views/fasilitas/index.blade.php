@extends('layouts.app')

@section('title', 'Fasilitas Sekolah - SD N 2 Dermolo')

@section('content')
<section class="pt-28 pb-12 px-4 bg-gradient-to-r from-indigo-600 to-sky-600">
    <div class="max-w-6xl mx-auto text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold">Fasilitas Sekolah</h1>
        <p class="mt-3 text-white/80 max-w-2xl mx-auto">
            Fasilitas modern untuk mendukung proses belajar yang optimal.
        </p>
    </div>
</section>

@php
    $namaToRoute = [
        'Ruang Kelas'       => 'fasilitas.ruang-kelas',
        'Perpustakaan'      => 'fasilitas.perpustakaan',
        'Musholla'          => 'fasilitas.musholla',
        'Lapangan Olahraga' => 'fasilitas.lapangan-olahraga',
    ];
    $warnaDesign = [
        'blue'   => ['gradient' => 'from-blue-50 to-blue-100', 'arrow' => 'text-blue-600'],
        'green'  => ['gradient' => 'from-emerald-50 to-emerald-100', 'arrow' => 'text-emerald-600'],
        'yellow' => ['gradient' => 'from-amber-50 to-amber-100', 'arrow' => 'text-amber-600'],
        'pink'   => ['gradient' => 'from-pink-50 to-pink-100', 'arrow' => 'text-pink-600'],
        'purple' => ['gradient' => 'from-purple-50 to-purple-100', 'arrow' => 'text-purple-600'],
        'orange' => ['gradient' => 'from-orange-50 to-orange-100', 'arrow' => 'text-orange-600'],
    ];
@endphp

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($fasilitas as $item)
            @php
                $isObj = is_object($item);
                $nama  = $isObj ? $item->nama : ($item['title'] ?? 'Fasilitas');
                $desk  = $isObj ? $item->deskripsi : ($item['description'] ?? '');
                $icon  = $isObj ? ($item->icon ?? '🏫') : ($item['emoji'] ?? '🏫');
                $iconImage = $isObj ? ($item->icon_image ?? null) : ($item['icon_image'] ?? null);
                $warna = $isObj ? ($item->warna ?? 'blue') : ($item['color'] ?? 'blue');
                $routeName = $isObj ? ($namaToRoute[$nama] ?? null) : ($item['route'] ?? null);
                $link = $routeName ? route($routeName) : '#';
                $fd = $warnaDesign[$warna] ?? $warnaDesign['blue'];
            @endphp
            <a href="{{ $link }}" class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition">
                <div class="h-36 flex items-center justify-center bg-gradient-to-r {{ $fd['gradient'] }}">
                    @if (!empty($iconImage))
                        <img src="{{ asset('storage/' . $iconImage) }}" alt="{{ $nama }}"
                             class="h-16 w-16 rounded-xl object-cover shadow-sm">
                    @else
                        <span class="text-4xl">{{ $icon }}</span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-slate-900">{{ $nama }}</h3>
                    <p class="text-sm text-slate-600 mt-1">{{ $desk }}</p>
                    <div class="text-xs font-semibold mt-3 {{ $fd['arrow'] }}">Lihat Detail -></div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
