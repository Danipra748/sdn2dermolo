@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Administrasi')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-4 gap-6 mb-8">
        <div class="metric-card rounded-3xl p-5">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Fasilitas</p>
            <p class="text-3xl font-semibold mt-3 text-slate-900">{{ $stats['total_fasilitas'] }}</p>
            <p class="text-xs text-slate-500 mt-2">Ruang yang terdata</p>
        </div>
        <div class="metric-card rounded-3xl p-5">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Guru</p>
            <p class="text-3xl font-semibold mt-3 text-slate-900">{{ $stats['total_guru'] }}</p>
            <p class="text-xs text-slate-500 mt-2">Tenaga pendidik aktif</p>
        </div>
        <div class="metric-card rounded-3xl p-5">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Program</p>
            <p class="text-3xl font-semibold mt-3 text-slate-900">{{ $stats['total_program'] }}</p>
            <p class="text-xs text-slate-500 mt-2">Program unggulan</p>
        </div>
        @if (isset($stats['total_articles']))
            <div class="metric-card rounded-3xl p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Artikel</p>
                <p class="text-3xl font-semibold mt-3 text-slate-900">{{ $stats['total_articles'] }}</p>
                <p class="text-xs text-slate-500 mt-2">{{ $stats['published_articles'] }} dipublikasikan</p>
            </div>
        @endif
        <div class="metric-card rounded-3xl p-5">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Status</p>
            <p class="text-xl font-semibold mt-3 text-slate-900">{{ $stats['status'] }}</p>
            <p class="text-xs text-slate-500 mt-2">Layanan website</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900">Aksi Cepat</h2>
            <p class="text-sm text-slate-500 mt-2">Buka halaman data yang ingin dikelola.</p>
            <div class="mt-5 flex flex-col gap-3">
                <a href="{{ route('admin.fasilitas.index') }}"
                    class="px-4 py-3 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition text-center">
                    Data Fasilitas
                </a>
                <a href="{{ route('admin.guru.index') }}"
                    class="px-4 py-3 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition text-center">
                    Data Guru
                </a>
                <a href="{{ route('admin.program-sekolah.index') }}"
                    class="px-4 py-3 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition text-center">
                    Program Sekolah
                </a>
                <a href="{{ route('admin.prestasi-sekolah.index') }}"
                    class="px-4 py-3 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition text-center">
                    Prestasi Sekolah
                </a>
                <a href="{{ route('admin.articles.index') }}"
                    class="px-4 py-3 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition text-center">
                    Artikel & News
                </a>
            </div>
        </div>

        <div class="glass rounded-3xl p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-slate-900">Ringkasan Data</h2>
            <p class="text-sm text-slate-500 mt-2">Sidebar sudah dipisah ke halaman manajemen masing-masing.</p>
            <div class="mt-5 grid md:grid-cols-3 gap-4 text-sm">
                <div class="rounded-2xl bg-white/70 p-4 border border-slate-200">
                    <p class="text-slate-500">Kelola Fasilitas</p>
                    <p class="text-xl font-semibold mt-2">{{ $stats['total_fasilitas'] }} Data</p>
                    <a href="{{ route('admin.fasilitas.index') }}" class="text-xs text-sky-600 mt-1 inline-block">Buka halaman</a>
                </div>
                <div class="rounded-2xl bg-white/70 p-4 border border-slate-200">
                    <p class="text-slate-500">Kelola Guru</p>
                    <p class="text-xl font-semibold mt-2">{{ $stats['total_guru'] }} Data</p>
                    <a href="{{ route('admin.guru.index') }}" class="text-xs text-sky-600 mt-1 inline-block">Buka halaman</a>
                </div>
                <div class="rounded-2xl bg-white/70 p-4 border border-slate-200">
                    <p class="text-slate-500">Kelola Program</p>
                    <p class="text-xl font-semibold mt-2">{{ $stats['total_program'] }} Data</p>
                    <a href="{{ route('admin.program-sekolah.index') }}" class="text-xs text-sky-600 mt-1 inline-block">Buka halaman</a>
                </div>
                @if (isset($stats['total_articles']))
                    <div class="rounded-2xl bg-white/70 p-4 border border-slate-200">
                        <p class="text-slate-500">Kelola Artikel</p>
                        <p class="text-xl font-semibold mt-2">{{ $stats['total_articles'] }} Data</p>
                        <a href="{{ route('admin.articles.index') }}" class="text-xs text-sky-600 mt-1 inline-block">Buka halaman</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
