@extends('layouts.app')

@section('title', 'Program Sekolah - SD N 2 Dermolo')

@section('content')
<section class="pt-28 pb-12 px-4 bg-gradient-to-r from-blue-600 to-sky-600">
    <div class="max-w-6xl mx-auto text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold">Program Sekolah</h1>
        <p class="mt-3 text-white/80 max-w-2xl mx-auto">
            Daftar program unggulan yang mendukung pengembangan karakter dan bakat siswa.
        </p>
    </div>
</section>

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($program as $item)
            @php
                $isObj = is_object($item);
                $title = $isObj ? $item->title : ($item['title'] ?? 'Program');
                $desc  = $isObj ? $item->desc  : ($item['desc'] ?? '');
                $logo  = $isObj ? ($item->logo ?? null) : null;
                $foto  = $isObj ? ($item->foto ?? null) : ($item['foto'] ?? null);
                $slug  = $isObj ? ($item->slug ?? null) : null;
                $routeName = $isObj ? ($slug ? 'program.' . $slug : null) : ($item['route'] ?? null);
                $link = $routeName ? route($routeName) : '#';

                $colorKey = $isObj
                    ? match ($slug) { 'pramuka' => 'blue', 'seni-ukir' => 'green', 'drumband' => 'yellow', default => 'blue' }
                    : ($item['color'] ?? 'blue');
                $gradients = [
                    'blue' => 'from-blue-600 to-sky-600',
                    'green' => 'from-emerald-600 to-green-700',
                    'yellow' => 'from-amber-500 to-orange-600',
                ];
                $gradient = $gradients[$colorKey] ?? $gradients['blue'];
            @endphp
            <a href="{{ $link }}" class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition">
                <div class="h-36 flex items-center justify-center bg-gradient-to-r {{ $gradient }}">
                    @if (!empty($logo))
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo {{ $title }}"
                             class="h-16 w-16 rounded-full object-cover border border-white/40 shadow-md">
                    @elseif (!empty($foto))
                        <img src="{{ asset('storage/' . $foto) }}" alt="{{ $title }}"
                             class="h-16 w-16 rounded-full object-cover border border-white/40 shadow-md">
                    @else
                        <span class="text-3xl text-white font-bold">{{ strtoupper(substr($title, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-slate-900">{{ $title }}</h3>
                    <p class="text-sm text-slate-600 mt-1">{{ $desc }}</p>
                    <div class="text-xs font-semibold text-blue-600 mt-3">Lihat Detail -></div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
