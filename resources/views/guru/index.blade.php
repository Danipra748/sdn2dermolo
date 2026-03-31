@extends('layouts.app')

@section('title', 'Guru & Tenaga Pendidik - SD N 2 Dermolo')

@section('content')
<section class="pt-28 pb-12 px-4 bg-gradient-to-r from-slate-900 to-slate-800">
    <div class="max-w-6xl mx-auto text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold">Guru & Tenaga Pendidik</h1>
        <p class="mt-3 text-white/70 max-w-2xl mx-auto">
            Profesional berdedikasi yang siap membimbing putra-putri Anda.
        </p>
    </div>
</section>

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        @if ($kepsek)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center gap-5">
                    <div class="h-20 w-20 rounded-full bg-slate-900 text-white flex items-center justify-center text-3xl overflow-hidden">
                        @if ($kepsek->photo)
                            <img src="{{ asset('storage/' . $kepsek->photo) }}" alt="{{ $kepsek->nama }}"
                                 class="w-full h-full object-cover object-center">
                        @else
                            <x-heroicon-o-user class="w-10 h-10 text-white" />
                        @endif
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Kepala Sekolah</div>
                        <div class="text-2xl font-semibold text-slate-900">{{ $kepsek->nama }}</div>
                        <div class="text-slate-600">{{ $kepsek->jabatan }}</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($guruLain as $g)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden">
                            @if ($g->photo)
                                <img src="{{ asset('storage/' . $g->photo) }}" alt="{{ $g->nama }}"
                                     class="w-full h-full object-cover object-center">
                            @else
                                <x-heroicon-o-user class="w-6 h-6 text-slate-500" />
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold text-slate-900">{{ $g->nama }}</div>
                            <div class="text-sm text-slate-600">{{ $g->jabatan }}</div>
                        </div>
                    </div>
                    <div class="text-xs text-slate-500 mt-3">
                        @if ($g->ijazah)
                            <div>Ijazah: {{ $g->ijazah }}</div>
                        @endif
                        @if ($g->gol)
                            <div>Gol: {{ $g->gol }}</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-slate-500">Data guru belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
