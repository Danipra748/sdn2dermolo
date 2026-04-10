@extends('layouts.app')

@section('title', 'Tentang Kami - SD N 2 Dermolo')
@section('meta_description', 'Profil lengkap SD N 2 Dermolo - Sejarah, Visi Misi, dan Identitas Sekolah')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative overflow-hidden text-white" style="padding-top: 100px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-20 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <x-heroicon-o-building-library class="h-4 w-4" /> PROFIL SEKOLAH
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Identitas Sekolah
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Mengenal lebih dekat visi, misi, dan profil lengkap SD N 2 Dermolo.
        </p>
    </div>
</section>

{{-- ===== IDENTITAS SEKOLAH ===== --}}
<section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">INFORMASI SEKOLAH</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-3">Identitas Sekolah</h2>
            <p class="text-slate-600 mt-3 max-w-2xl mx-auto">Data lengkap dan informasi kontak SD N 2 Dermolo</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- School Profile Card --}}
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-3xl p-8 text-center text-white shadow-2xl relative overflow-hidden">
                    {{-- Background Pattern --}}
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 30px 30px;"></div>
                    
                    {{-- Logo --}}
                    <div class="relative z-10">
                        <div class="w-32 h-32 mx-auto mb-4 rounded-2xl bg-white shadow-2xl overflow-hidden">
                            @if($profile->logo)
                                <img src="{{ asset('storage/' . $profile->logo) }}" alt="{{ $profile->school_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-5xl font-bold text-blue-600">SD</div>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="text-2xl font-bold mb-2">{{ $profile->school_name }}</h3>
                        <p class="text-blue-100 text-sm mb-4">{{ $profile->address ?? 'Desa Dermolo' }}</p>
                        
                        {{-- Accreditation Badge --}}
                        <div class="inline-block px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-semibold mb-4">
                            🏆 Akreditasi {{ $profile->accreditation ?? 'B' }}
                        </div>
                        
                        {{-- Quick Stats --}}
                        <div class="grid grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/20">
                            <div>
                                <div class="text-2xl font-bold">{{ $profile->established_year ?? '1975' }}</div>
                                <div class="text-xs text-blue-100">Tahun Berdiri</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $profile->total_classes ?? '12' }}</div>
                                <div class="text-xs text-blue-100">Kelas</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold">{{ $profile->land_area ?? '1.400' }}</div>
                                <div class="text-xs text-blue-100">Luas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- School Information Cards --}}
            <div class="lg:col-span-2">
                <div class="grid md:grid-cols-2 gap-4">
                    {{-- Basic Info Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <x-heroicon-o-document-text class="w-5 h-5 text-blue-600" />
                            </div>
                            <h4 class="font-bold text-slate-900">Informasi Dasar</h4>
                        </div>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                <span class="text-slate-500">NPSN</span>
                                <span class="font-semibold text-slate-900">{{ $profile->npsn ?? '20318087' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                <span class="text-slate-500">Status</span>
                                <span class="font-semibold text-slate-900">{{ $profile->school_status }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                <span class="text-slate-500">Akreditasi</span>
                                <span class="font-semibold text-slate-900">{{ $profile->accreditation ?? 'B' }} (BAN-S/M)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Kecamatan</span>
                                <span class="font-semibold text-slate-900">{{ $profile->district ?? 'Kembang' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Location Card with Google Maps --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                <x-heroicon-o-map-pin class="w-5 h-5 text-green-600" />
                            </div>
                            <h4 class="font-bold text-slate-900">Lokasi Sekolah</h4>
                        </div>
                        
                        {{-- Google Maps Embed --}}
                        @include('partials.school-map-embed', [
                            'containerClass' => 'kontak-map relative overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm',
                            'height' => '280px',
                        ])
                        {{--
                        <div class="hidden relative rounded-xl overflow-hidden border border-slate-200 shadow-sm" style="height: 280px;" aria-hidden="true">
                            <iframe
                                title="Lokasi SD N 2 Dermolo"
                                src="about:blank"
                                class="w-full h-full border-0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen>
                            </iframe>
                            <div class="absolute bottom-2 right-2 rounded-full bg-white/95 px-3 py-1 text-[0.7rem] font-semibold text-slate-700 shadow backdrop-blur-sm">
                                📍 SD N 2 Dermolo
                            </div>
                        </div>
                        --}}
                        
                        {{-- Open in Google Maps Button --}}
                        <a href="{{ $mapsOpen }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-green-600 to-emerald-600 text-white text-sm font-semibold hover:from-green-700 hover:to-emerald-700 transition shadow-md hover:shadow-lg hover:-translate-y-0.5">
                            <x-heroicon-o-map class="w-4 h-4" />
                            Buka di Google Maps
                        </a>
                        
                        {{-- Quick Info --}}
                        <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-sm">
                            <div class="flex items-start gap-2">
                                <x-heroicon-o-map-pin class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5" />
                                <div>
                                    <div class="text-xs text-slate-500">Alamat</div>
                                    <div class="font-semibold text-slate-900">{{ $alamatLines->implode(', ') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Card --}}
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition md:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                <x-heroicon-o-phone class="w-5 h-5 text-purple-600" />
                            </div>
                            <h4 class="font-bold text-slate-900">Kontak & Komunikasi</h4>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $profile->phone ?? '') }}" class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-blue-50 transition group">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <x-heroicon-o-phone class="w-4 h-4 text-blue-600" />
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-500">Telepon</div>
                                        <div class="font-semibold text-slate-900 group-hover:text-blue-600">{{ $profile->phone ?? '(0291) 123-456' }}</div>
                                    </div>
                                </a>
                                
                                <a href="mailto:{{ $profile->email }}" class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-green-50 transition group">
                                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                        <x-heroicon-o-envelope class="w-4 h-4 text-green-600" />
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-500">Email</div>
                                        <div class="font-semibold text-slate-900 group-hover:text-green-600 text-sm">{{ $profile->email ?? 'sdn2dermolo@gmail.com' }}</div>
                                    </div>
                                </a>
                            </div>
                            
                            @if($profile->website)
                            <a href="{{ $profile->website }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 hover:bg-purple-50 transition group">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <x-heroicon-o-globe-alt class="w-4 h-4 text-purple-600" />
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Website</div>
                                    <div class="font-semibold text-slate-900 group-hover:text-purple-600 text-sm">{{ $profile->website }}</div>
                                </div>
                            </a>
                            @endif
                            
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <x-heroicon-o-clock class="w-4 h-4 text-amber-600" />
                                </div>
                                <div>
                                    <div class="text-xs text-slate-500">Jam Operasional</div>
                                    <div class="font-semibold text-slate-900 text-sm">07:00 - 14:00 WIB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== VISI & MISI ===== --}}
@if($profile->vision || ($profile->missions && count($profile->missions) > 0))
<section class="py-16 px-4 bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">VISI & MISI</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-3">Arah & Tujuan Kami</h2>
        </div>

        {{-- Vision --}}
        @if($profile->vision)
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 md:p-12 text-white text-center shadow-2xl">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <x-heroicon-o-eye class="w-8 h-8 text-white" />
                </div>
                <h3 class="text-xl font-bold mb-4">VISI</h3>
                <p class="text-lg md:text-xl italic leading-relaxed">"{{ $profile->vision }}"</p>
            </div>
        </div>
        @endif

        {{-- Mission Cards --}}
        @if($profile->missions && count($profile->missions) > 0)
        <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($profile->missions as $index => $mission)
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center text-lg font-bold mb-4">
                    {{ $index + 1 }}
                </div>
                <p class="text-slate-700 leading-relaxed">{{ $mission }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Button Lihat Selengkapnya (akan scroll ke sejarah) --}}
        <div class="text-center mt-12">
            <a href="#sejarah" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                <x-heroicon-o-book-open class="w-5 h-5" />
                Lihat Sejarah Sekolah
            </a>
        </div>
    </div>
</section>
@endif

{{-- ===== SEJARAH SEKOLAH ===== --}}
@if($profile->history_content)
<section id="sejarah" class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <span class="px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold">SEJARAH SEKOLAH</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-3">Perjalanan Panjang {{ $profile->school_name }}</h2>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- History Content --}}
            <div class="lg:col-span-2">
                <div class="prose prose-lg max-w-none">
                    <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $profile->history_content }}</p>
                </div>
            </div>

            {{-- Fakta Singkat Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl p-6 border border-slate-200 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <x-heroicon-o-chart-bar class="w-5 h-5 text-blue-600" />
                        Fakta Singkat
                    </h3>
                    <div class="space-y-3 text-sm">
                        @if($profile->established_year)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tahun Berdiri</span>
                            <span class="font-semibold text-slate-900">{{ $profile->established_year }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status</span>
                            <span class="font-semibold text-slate-900">{{ $profile->school_status }} (SDN)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Akreditasi</span>
                            <span class="font-semibold text-slate-900">{{ $profile->accreditation ?? 'B' }} (BAN-S/M)</span>
                        </div>
                        @if($profile->total_classes)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Jumlah Kelas</span>
                            <span class="font-semibold text-slate-900">{{ $profile->total_classes }} Rombel</span>
                        </div>
                        @endif
                        @if($profile->total_students)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Total Siswa</span>
                            <span class="font-semibold text-slate-900">{{ number_format($profile->total_students) }}+</span>
                        </div>
                        @endif
                        @if($profile->land_area)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Luas Tanah</span>
                            <span class="font-semibold text-slate-900">± {{ $profile->land_area }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== BACK TO HOME BUTTON ===== --}}
<section class="py-12 px-4 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl">
            <x-heroicon-o-arrow-left class="w-5 h-5" />
            Kembali ke Beranda
        </a>
    </div>
</section>

@endsection
