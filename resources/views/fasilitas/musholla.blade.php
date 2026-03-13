@extends('layouts.app')

@section('title', 'Musholla - SD N 2 Dermolo')

@section('content')
<section class="pt-32 pb-16 px-4 bg-gradient-to-r {{ $data['hero_color'] }}">
    <div class="max-w-7xl mx-auto text-center animate-fadeIn">
        <div class="inline-block mb-4">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto shadow-2xl">
            @if (!empty($data['icon_image']))
                <img src="{{ asset('storage/' . $data['icon_image']) }}" alt="{{ $data['title'] ?? 'Fasilitas' }}"
                     class="w-20 h-20 rounded-full object-cover">
            @else
                <span class="text-5xl">{{ $data['emoji'] }}</span>
            @endif
        </div>
        </div>
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">{{ $data['title'] }}</h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto">{{ $data['subtitle'] }}</p>
    </div>
</section>

<section class="py-16 px-4 bg-gradient-to-br from-emerald-50 to-teal-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('fasilitas.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-800 font-semibold transition">
                <- {{ $data['back_button_text'] ?? 'Kembali ke Fasilitas' }}
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12 border-t-4 border-emerald-500">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $data['description_title'] ?? 'Tentang Fasilitas' }}</h2>
            @foreach(($data['description_paragraphs'] ?? []) as $paragraph)
                <p class="text-gray-600 leading-relaxed {{ $loop->last ? '' : 'mb-4' }}">{{ $paragraph }}</p>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ $data['stats_title'] ?? 'Data Fasilitas' }}</h2>
            @php
                $colors = [
                    'indigo' => ['bg' => 'from-indigo-100 to-indigo-200', 'text' => 'text-indigo-800', 'sub' => 'text-indigo-700'],
                    'purple' => ['bg' => 'from-purple-100 to-purple-200', 'text' => 'text-purple-800', 'sub' => 'text-purple-700'],
                    'pink' => ['bg' => 'from-pink-100 to-pink-200', 'text' => 'text-pink-800', 'sub' => 'text-pink-700'],
                    'orange' => ['bg' => 'from-orange-100 to-orange-200', 'text' => 'text-orange-800', 'sub' => 'text-orange-700'],
                    'emerald' => ['bg' => 'from-emerald-100 to-emerald-200', 'text' => 'text-emerald-800', 'sub' => 'text-emerald-700'],
                ];
            @endphp
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(($data['stats'] ?? []) as $stat)
                    @php $c = $colors[$stat['color'] ?? 'emerald'] ?? $colors['emerald']; @endphp
                    <div class="bg-gradient-to-br {{ $c['bg'] }} rounded-xl p-6 text-center hover:shadow-xl transition">
                        <div class="text-5xl mb-3">{{ $stat['icon'] ?? '•' }}</div>
                        <h3 class="font-bold text-3xl {{ $c['text'] }} mb-2">{{ $stat['value'] ?? '-' }}</h3>
                        <p class="{{ $c['sub'] }} font-medium">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ $data['program_title'] ?? 'Program' }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach(($data['program'] ?? []) as $item)
                    <div class="p-6 border border-{{ $item['color'] ?? 'emerald' }}-100 rounded-xl bg-{{ $item['color'] ?? 'emerald' }}-50">
                        <h3 class="font-bold text-xl text-{{ $item['color'] ?? 'emerald' }}-900 mb-2">{{ $item['title'] ?? '' }}</h3>
                        <p class="text-gray-600 text-sm">{{ $item['desc'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $data['rules_title'] ?? 'Tata Tertib' }}</h2>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach(($data['tata_tertib_boleh'] ?? []) as $rule)
                    <div class="flex items-start space-x-3 p-4 bg-emerald-50 rounded-lg border-l-4 border-emerald-500">
                        <span class="text-2xl">OK</span>
                        <p class="text-gray-700">{{ $rule }}</p>
                    </div>
                @endforeach
                @foreach(($data['tata_tertib_larang'] ?? []) as $rule)
                    <div class="flex items-start space-x-3 p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                        <span class="text-2xl">NO</span>
                        <p class="text-gray-700">{{ $rule }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="py-16 px-4 bg-gradient-to-r from-emerald-600 to-teal-700">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-4">{{ $data['cta_title'] ?? '' }}</h2>
        <p class="text-xl text-emerald-100 mb-8">{{ $data['cta_subtitle'] ?? '' }}</p>
        <a href="{{ route('home') }}#fasilitas" class="bg-white hover:bg-gray-100 text-emerald-700 font-bold py-4 px-10 rounded-full transition shadow-xl text-lg inline-block">
            {{ $data['cta_button_text'] ?? 'Lihat Fasilitas Lainnya' }} ->
        </a>
    </div>
</section>
@endsection
