@extends('layouts.app')

@section('title', $data['title'].' - SD N 2 Dermolo')

@section('content')
<section class="pt-32 pb-16 px-4 bg-gradient-to-r {{ $data['hero_color'] }} relative overflow-hidden"
    @if (!empty($data['card_bg_image']))
        style="background-image: url('{{ asset('storage/' . $data['card_bg_image']) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
    @endif>
    @if (!empty($data['card_bg_image']))
        <div class="absolute inset-0 bg-slate-900/45"></div>
    @endif
    <div class="max-w-7xl mx-auto text-center animate-fadeIn relative z-10">
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">{{ $data['title'] }}</h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto">{{ $data['subtitle'] }}</p>
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

        <div class="bg-white rounded-2xl shadow-xl p-8 mb-10 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Deskripsi Program</h2>
            <p class="text-slate-600 leading-relaxed mb-4">
                Halaman ini disiapkan untuk menampilkan dokumentasi lengkap kegiatan program.
                Anda dapat menambahkan galeri foto, jadwal kegiatan, dan laporan capaian siswa.
            </p>
            <div class="grid md:grid-cols-3 gap-4 mt-6">
                @foreach ($data['highlights'] as $point)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">{{ $point }}</div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-dashed border-slate-300">
            <h3 class="text-xl font-semibold text-slate-900 mb-3">Area Dokumentasi Foto</h3>
            <p class="text-slate-600 mb-6">Tempatkan foto kegiatan program pada area ini (nanti bisa dibuat galeri dinamis).</p>
            @php
                $docCaptions = [
                    "Kegiatan {$data['title']} bersama siswa.",
                    "Dokumentasi latihan dan pembelajaran rutin.",
                    "Momen kebersamaan dan pengembangan bakat.",
                ];
            @endphp
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if (!empty($data['photos']))
                    @foreach ($data['photos'] as $photo)
                        <div>
                            <div class="h-44 rounded-xl border border-slate-200 overflow-hidden">
                                <img src="{{ asset('storage/' . $photo['photo']) }}" alt="Dokumentasi {{ $data['title'] }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs text-slate-600 mt-2">
                                {{ $photo['caption'] ?: 'Dokumentasi kegiatan program.' }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <div>
                        <div class="h-44 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-sm">Foto 1</div>
                        <p class="text-xs text-slate-600 mt-2">{{ $docCaptions[0] }}</p>
                    </div>
                    <div>
                        <div class="h-44 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-sm">Foto 2</div>
                        <p class="text-xs text-slate-600 mt-2">{{ $docCaptions[1] }}</p>
                    </div>
                    <div>
                        <div class="h-44 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-sm">Foto 3</div>
                        <p class="text-xs text-slate-600 mt-2">{{ $docCaptions[2] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
