@extends('layouts.app')

@section('title', 'Program Sekolah - SD N 2 Dermolo')

@section('content')
<section class="min-h-[600px] pt-32 pb-16 px-4 relative overflow-hidden"
    @if (!empty($heroBg))
        style="background-image: url('{{ asset('storage/' . $heroBg) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
    @else
        style="background: linear-gradient(90deg, #2563eb, #0284c7);"
    @endif>
    @if (!empty($heroBg))
        <div class="absolute inset-0 bg-slate-900/40"></div>
    @endif
    <div class="max-w-7xl mx-auto text-center text-white relative z-10">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Program Sekolah</h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto">
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
                $emoji = $isObj ? ($item->emoji ?? null) : ($item['emoji'] ?? null);
                $cardBg = $isObj ? ($item->card_bg_image ?? null) : ($item['card_bg_image'] ?? null);
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
                @php
                    $bgStyle = !empty($cardBg)
                        ? "background-image: url('" . asset('storage/' . $cardBg) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                        : '';
                @endphp
                <div class="h-36 flex items-center justify-center bg-gradient-to-r {{ $gradient }}"
                     style="{{ $bgStyle }}">
                    @if (empty($cardBg))
                        @if (!empty($logo))
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo {{ $title }}"
                                 class="w-full h-full object-cover">
                        @elseif (!empty($foto))
                            <img src="{{ asset('storage/' . $foto) }}" alt="{{ $title }}"
                                 class="w-full h-full object-cover">
                        @elseif (!empty($emoji))
                            <span class="text-3xl text-white font-bold">{{ $emoji }}</span>
                        @else
                            <span class="text-3xl text-white font-bold">{{ strtoupper(substr($title, 0, 1)) }}</span>
                        @endif
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
