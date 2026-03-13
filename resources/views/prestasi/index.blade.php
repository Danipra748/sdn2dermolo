@extends('layouts.app')

@section('title', 'Prestasi Sekolah - SD N 2 Dermolo')

@section('content')
<section class="pt-32 pb-16 px-4 bg-gradient-to-r {{ $data['hero_color'] }}">
    <div class="max-w-7xl mx-auto text-center animate-fadeIn">
        <div class="inline-block mb-4">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto shadow-2xl">
                <span class="text-5xl">{{ $data['initial'] }}</span>
            </div>
        </div>
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">{{ $data['title'] }}</h1>
        <p class="text-xl text-white/80 max-w-3xl mx-auto">{{ $data['subtitle'] }}</p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-800 font-semibold transition">
                <- Kembali ke Beranda
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 mb-10 border border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Ringkasan Prestasi</h2>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach ($data['items'] as $item)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700">{{ $item }}</div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-dashed border-slate-300">
            <h3 class="text-xl font-semibold text-slate-900 mb-3">Area Dokumentasi Prestasi</h3>
            <p class="text-slate-600 mb-6">Foto dokumentasi ini diambil dari data Prestasi Sekolah di panel admin.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($data['dokumentasi'] as $dok)
                    <div class="rounded-xl bg-white border border-slate-200 overflow-hidden">
                        @if (!empty($dok['foto']))
                            <img src="{{ asset('storage/' . $dok['foto']) }}" alt="{{ $dok['judul'] }}"
                                 class="h-44 w-full object-cover">
                        @else
                            <div class="h-44 bg-slate-100 flex items-center justify-center text-slate-500 text-sm">
                                Foto Belum Ada
                            </div>
                        @endif
                        <div class="p-3">
                            <p class="text-sm font-semibold text-slate-900">{{ $dok['judul'] }}</p>
                            <p class="text-xs text-slate-500 mt-1">
                                {{ !empty($dok['deskripsi']) ? $dok['deskripsi'] : 'Dokumentasi prestasi siswa dan sekolah.' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="h-44 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-sm">
                        Belum ada dokumentasi prestasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
