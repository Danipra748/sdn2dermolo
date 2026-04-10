@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Administrasi')

@section('content')
    {{-- Form upload logo dan sambutan sengaja dipindahkan ke halaman hidden settings agar dashboard presentasi tetap bersih. --}}
    @if (session('status'))
        <div class="mb-6 alert-success flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="metric-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.15em] text-slate-500 font-medium">Fasilitas</p>
                <div class="w-10 h-10 rounded-xl bg-cyan/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['total_fasilitas'] }}</p>
            <p class="text-sm text-slate-500">Ruang yang terdata</p>
        </div>

        <div class="metric-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.15em] text-slate-500 font-medium">Guru</p>
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['total_guru'] }}</p>
            <p class="text-sm text-slate-500">Tenaga pendidik aktif</p>
        </div>

        <div class="metric-card">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs uppercase tracking-[0.15em] text-slate-500 font-medium">Program</p>
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['total_program'] }}</p>
            <p class="text-sm text-slate-500">Program unggulan</p>
        </div>

        @if (isset($stats['total_articles']))
            <div class="metric-card">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs uppercase tracking-[0.15em] text-slate-500 font-medium">Artikel</p>
                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-800 mb-1">{{ $stats['total_articles'] }}</p>
                <p class="text-sm text-slate-500">{{ $stats['published_articles'] }} dipublikasikan</p>
            </div>
        @endif

        @if (!isset($stats['total_articles']))
            <div class="metric-card">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs uppercase tracking-[0.15em] text-slate-500 font-medium">Status</p>
                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-slate-800 mb-1">{{ $stats['status'] }}</p>
                <p class="text-sm text-slate-500">Layanan website</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="modern-card p-6 lg:col-span-1">
            <h2 class="text-lg font-semibold text-slate-800 mb-2">Aksi Cepat</h2>
            <p class="text-sm text-slate-500 mb-5">Buka halaman data yang ingin dikelola.</p>
            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.fasilitas.index') }}"
                    class="btn-primary text-center">
                    Data Fasilitas
                </a>
                <a href="{{ route('admin.guru.index') }}"
                    class="btn-secondary text-center">
                    Data Guru
                </a>
                <a href="{{ route('admin.program-sekolah.index') }}"
                    class="btn-secondary text-center">
                    Program Sekolah
                </a>
                <a href="{{ route('admin.prestasi-sekolah.index') }}"
                    class="btn-secondary text-center">
                    Prestasi Sekolah
                </a>
                <a href="{{ route('admin.articles.index') }}"
                    class="btn-secondary text-center">
                    Artikel & News
                </a>
            </div>
        </div>

        <div class="modern-card p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-slate-800 mb-2">Ringkasan Data</h2>
            <p class="text-sm text-slate-500 mb-5">Sidebar sudah dipisah ke halaman manajemen masing-masing.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 hover:border-cyan/50 transition">
                    <p class="text-sm text-slate-500 mb-2">Kelola Fasilitas</p>
                    <p class="text-2xl font-bold text-slate-800 mb-2">{{ $stats['total_fasilitas'] }} Data</p>
                    <a href="{{ route('admin.fasilitas.index') }}" class="text-sm text-cyan font-medium hover:underline">Buka halaman →</a>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 hover:border-cyan/50 transition">
                    <p class="text-sm text-slate-500 mb-2">Kelola Guru</p>
                    <p class="text-2xl font-bold text-slate-800 mb-2">{{ $stats['total_guru'] }} Data</p>
                    <a href="{{ route('admin.guru.index') }}" class="text-sm text-cyan font-medium hover:underline">Buka halaman →</a>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 hover:border-cyan/50 transition">
                    <p class="text-sm text-slate-500 mb-2">Kelola Program</p>
                    <p class="text-2xl font-bold text-slate-800 mb-2">{{ $stats['total_program'] }} Data</p>
                    <a href="{{ route('admin.program-sekolah.index') }}" class="text-sm text-cyan font-medium hover:underline">Buka halaman →</a>
                </div>
                @if (isset($stats['total_articles']))
                    <div class="rounded-xl bg-slate-50 p-4 border border-slate-200 hover:border-cyan/50 transition">
                        <p class="text-sm text-slate-500 mb-2">Kelola Artikel</p>
                        <p class="text-2xl font-bold text-slate-800 mb-2">{{ $stats['total_articles'] }} Data</p>
                        <a href="{{ route('admin.articles.index') }}" class="text-sm text-cyan font-medium hover:underline">Buka halaman →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
