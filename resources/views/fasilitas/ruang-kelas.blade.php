@extends('layouts.app')

@section('title', 'Ruang Kelas - SD N 2 Dermolo')

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

<section class="py-16 px-4 bg-gradient-to-br from-blue-50 to-cyan-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('fasilitas.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                <- {{ $data['back_button_text'] ?? 'Kembali ke Fasilitas' }}
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12 border-t-4 {{ $data['border_color'] ?? 'border-blue-500' }}">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $data['description_title'] ?? 'Tentang Fasilitas' }}</h2>
            @foreach(($data['description_paragraphs'] ?? []) as $paragraph)
                <p class="text-gray-600 leading-relaxed {{ $loop->last ? '' : 'mb-4' }}">{{ $paragraph }}</p>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ $data['stats_title'] ?? 'Data Fasilitas' }}</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach(($data['stats'] ?? []) as $stat)
                    <div class="bg-gradient-to-br from-{{ $stat['color'] ?? 'blue' }}-100 to-{{ $stat['color'] ?? 'blue' }}-200 rounded-xl p-6 text-center hover:shadow-xl transition">
                        <div class="text-5xl mb-3">{{ $stat['icon'] ?? '•' }}</div>
                        <h3 class="font-bold text-3xl text-{{ $stat['color'] ?? 'blue' }}-800 mb-2">{{ $stat['value'] ?? '-' }}</h3>
                        <p class="text-{{ $stat['color'] ?? 'blue' }}-700 font-medium">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ $data['kelas_title'] ?? 'Pembagian Ruang Kelas' }}</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(($data['kelas'] ?? []) as $kelas)
                    <div class="bg-gradient-to-br from-{{ $kelas['color'] ?? 'blue' }}-50 to-{{ $kelas['color'] ?? 'blue' }}-100 rounded-xl p-6 border-l-4 border-{{ $kelas['color'] ?? 'blue' }}-500">
                        <h3 class="font-bold text-2xl text-gray-800 mb-2">{{ $kelas['level'] ?? '-' }}</h3>
                        <p class="text-gray-600 mb-3">{{ count($kelas['rooms'] ?? []) }} Ruang Kelas</p>
                        <ul class="space-y-1 text-sm text-gray-700">
                            @foreach(($kelas['rooms'] ?? []) as $room)
                                <li>- {{ $room }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ $data['fasilitas_title'] ?? 'Fasilitas dan Kelengkapan' }}</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach(($data['fasilitas_items'] ?? []) as $item)
                    <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-lg hover:shadow-md transition">
                        <div class="text-3xl">{{ $item['icon'] ?? '•' }}</div>
                        <div>
                            <h3 class="font-bold text-gray-800 mb-1">{{ $item['title'] ?? '' }}</h3>
                            <p class="text-gray-600 text-sm">{{ $item['desc'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ $data['rules_title'] ?? 'Tata Tertib' }}</h2>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach(($data['tata_tertib_boleh'] ?? []) as $rule)
                    <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
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

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $data['program_title'] ?? 'Program' }}</h2>
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border-2 border-yellow-300">
                <h3 class="font-bold text-2xl text-gray-800 mb-4">{{ $data['program_subtitle'] ?? '' }}</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach(($data['program_sections'] ?? []) as $section)
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800 mb-3">{{ $section['title'] ?? '' }}</h4>
                            <ul class="space-y-2 text-gray-700 text-sm">
                                @foreach(($section['items'] ?? []) as $item)
                                    <li>- {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 px-4 bg-gradient-to-r from-blue-500 to-cyan-600">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-4">{{ $data['cta_title'] ?? '' }}</h2>
        <p class="text-xl text-blue-100 mb-8">{{ $data['cta_subtitle'] ?? '' }}</p>
        <a href="{{ route('home') }}#fasilitas" class="bg-white hover:bg-gray-100 text-blue-700 font-bold py-4 px-10 rounded-full transition shadow-xl text-lg inline-block">
            {{ $data['cta_button_text'] ?? 'Lihat Fasilitas Lainnya' }} ->
        </a>
    </div>
</section>
@endsection
