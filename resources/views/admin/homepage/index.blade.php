@extends('admin.layout')

@section('title', 'Pengaturan Beranda')
@section('heading', 'Pengaturan Hero Section')

@section('content')
    <div class="max-w-4xl">
        {{-- Info Card - Static Configuration --}}
        <div class="glass rounded-3xl p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Hero Section - Konfigurasi Statis</h2>
                    <p class="text-sm text-slate-500 mt-1">Bagian paling atas halaman beranda (sudah statis)</p>
                </div>
                @if($staticHero['is_active'] ?? true)
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                        ✓ Aktif
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                        Nonaktif
                    </span>
                @endif
            </div>

            {{-- Static Configuration Display --}}
            <div class="rounded-2xl bg-blue-50 border border-blue-200 p-6 mb-6">
                <div class="flex items-start gap-3">
                    <x-heroicon-o-information-circle class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" />
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">Informasi Konfigurasi Statis</h3>
                        <p class="text-sm text-blue-700">
                            Hero section sekarang menggunakan konfigurasi statis dari file <code class="bg-blue-100 px-2 py-0.5 rounded">config/school.php</code>. 
                            Data tidak lagi dapat diubah melalui panel admin. Untuk mengubah data, silakan edit file konfigurasi secara langsung.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Hero Configuration Details --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-xs text-slate-500 mb-1">Title</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $staticHero['title'] ?? 'Sekolah yang' }}</p>
                </div>
                <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-xs text-slate-500 mb-1">Subtitle</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $staticHero['subtitle'] ?? 'Membentuk' }}</p>
                </div>
                <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-xs text-slate-500 mb-1">Overlay Opacity</p>
                    <p class="text-sm font-semibold text-slate-900">{{ round(($staticHero['background_overlay_opacity'] ?? 0.35) * 100) }}%</p>
                </div>
                <div class="rounded-xl bg-white border border-slate-200 p-4">
                    <p class="text-xs text-slate-500 mb-1">Badge Text</p>
                    <p class="text-sm font-semibold text-slate-900">{{ Str::limit($staticHero['badge_text'] ?? 'SELAMAT DATANG DI SD N 2 DERMolo', 30) }}</p>
                </div>
            </div>

            {{-- Database Hero Info (if exists) --}}
            @if($hero)
                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-semibold text-slate-900 mb-4">Data dari Database (Background Images)</h3>
                    
                    @if($hero->background_image)
                        <div class="mb-4">
                            <label class="block text-xs text-slate-500 mb-2">Background Image Utama</label>
                            <div class="relative rounded-xl overflow-hidden border border-slate-200">
                                <img src="{{ asset('storage/' . $hero->background_image) }}"
                                     alt="Hero Background"
                                     class="w-full h-48 object-cover">
                            </div>
                            <p class="text-xs text-slate-600 mt-2 font-mono">{{ $hero->background_image }}</p>
                        </div>
                    @endif

                    @if(isset($hero->extra_data['slideshow_images']) && is_array($hero->extra_data['slideshow_images']))
                        <div>
                            <label class="block text-xs text-slate-500 mb-2">
                                Slideshow Images ({{ count($hero->extra_data['slideshow_images']) }})
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($hero->extra_data['slideshow_images'] as $img)
                                    <div class="relative rounded-lg overflow-hidden border border-slate-200">
                                        <img src="{{ asset('storage/' . $img) }}"
                                             alt="Slideshow"
                                             class="w-full h-24 object-cover">
                                    </div>
                                    <p class="text-xs text-slate-600 font-mono truncate mt-1">{{ $img }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="border-t border-slate-200 pt-6">
                    <div class="w-full h-48 bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                        <div class="text-center">
                            <x-heroicon-o-photo class="w-12 h-12 mx-auto mb-2 opacity-50" />
                            <p class="text-sm">Belum ada background image dari database</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3 mb-6">
            <a href="{{ route('home') }}" target="_blank"
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                <x-heroicon-o-eye class="w-4 h-4" />
                Lihat Beranda
            </a>
            <a href="{{ route('admin.school-profile.edit') }}"
               class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                <x-heroicon-o-cog class="w-4 h-4" />
                Profil Sekolah
            </a>
        </div>

        {{-- How to Edit Static Config --}}
        <div class="rounded-2xl bg-amber-50 border border-amber-200 p-6">
            <div class="flex items-start gap-3">
                <x-heroicon-o-cog class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" />
                <div>
                    <h3 class="font-semibold text-amber-900 mb-2">Cara Mengubah Konfigurasi Statis</h3>
                    <p class="text-sm text-amber-800 mb-3">
                        Untuk mengubah pengaturan hero section, edit file konfigurasi di:
                    </p>
                    <code class="block bg-amber-100 p-3 rounded-lg text-amber-900 text-xs mb-3">
                        config/school.php
                    </code>
                    <p class="text-sm text-amber-800 mb-2">
                        <strong>Contoh yang bisa diubah:</strong>
                    </p>
                    <ul class="text-sm text-amber-800 space-y-1 list-disc list-inside">
                        <li><code class="bg-amber-100 px-2 py-0.5 rounded">homepage.hero.title</code> - Judul hero section</li>
                        <li><code class="bg-amber-100 px-2 py-0.5 rounded">homepage.hero.subtitle</code> - Subtitle hero section</li>
                        <li><code class="bg-amber-100 px-2 py-0.5 rounded">homepage.hero.background_overlay_opacity</code> - Tingkat kegelapan overlay (0-1)</li>
                        <li><code class="bg-amber-100 px-2 py-0.5 rounded">homepage.hero.badge_text</code> - Text badge di atas judul</li>
                    </ul>
                    <p class="text-sm text-amber-800 mt-3">
                        <strong>Setelah mengubah file,</strong> jalankan: <code class="bg-amber-100 px-2 py-0.5 rounded">php artisan config:clear</code>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
