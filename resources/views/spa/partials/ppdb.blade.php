@php use Carbon\Carbon; @endphp
{{-- PPDB Landing SPA Partial --}}

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-20px) rotate(2deg); }
    }
    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.2; }
        100% { transform: scale(0.8); opacity: 0.5; }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-pulse-ring { animation: pulse-ring 4s ease-in-out infinite; }
</style>

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            PPDB ONLINE
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Penerimaan Peserta Didik Baru
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Selamat datang di layanan pendaftaran mandiri calon siswa baru SD N 2 Dermolo.
        </p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50 min-h-[600px]" 
         id="ppdb-main-container"
         data-ppdb-state="{{ $status }}"
         data-ppdb-start="{{ $settings->start_date ? $settings->start_date->toIso8601String() : '' }}"
         data-ppdb-end="{{ $settings->end_date ? $settings->end_date->toIso8601String() : '' }}">
    <div class="max-w-6xl mx-auto">
        
        @if($status === 'waiting')
            {{-- State: Waiting (Segera Mulai) --}}
            <div class="flex flex-col items-center text-center py-12 reveal">
                <div class="relative w-64 h-64 mb-8">
                    <div class="absolute inset-0 bg-amber-400/20 rounded-full animate-pulse-ring"></div>
                    <svg viewBox="0 0 200 200" class="w-full h-full animate-float relative z-10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" fill="white" fill-opacity="0.9" />
                        <path d="M100 50V100L130 115" stroke="#D97706" stroke-width="8" stroke-linecap="round" stroke-linejoin="round">
                            <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="10s" repeatCount="indefinite" />
                        </path>
                        <rect x="85" y="85" width="30" height="30" rx="15" fill="#FBBF24" />
                        <path d="M60 150C60 150 80 130 100 130C120 130 140 150 140 150" stroke="#D97706" stroke-width="6" stroke-linecap="round" />
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-slate-900 mb-4">Pendaftaran Segera Dimulai</h2>
                <p class="text-slate-600 max-w-lg mb-8">Persiapkan berkas Anda! Kami sedang menyiapkan gerbang pendaftaran digital untuk menyambut calon siswa baru.</p>
                <div class="bg-white px-8 py-4 rounded-3xl shadow-xl border border-blue-100 mb-8">
                    <div class="text-blue-600 font-black text-xl mb-1">{{ $settings->start_date->translatedFormat('d F Y') }}</div>
                    <div class="text-slate-400 text-sm font-bold uppercase tracking-widest">Pukul {{ $settings->start_date->format('H:i') }} WIB</div>
                </div>
                <div id="ppdb-countdown" data-until="{{ $settings->start_date->toIso8601String() }}" class="flex gap-4 justify-center"></div>
            </div>

        @elseif($status === 'closed')
            {{-- State: Closed (Selesai) --}}
            <div class="flex flex-col items-center text-center py-12 reveal">
                <div class="relative w-64 h-64 mb-8">
                    <div class="absolute inset-0 bg-slate-400/20 rounded-full"></div>
                    <svg viewBox="0 0 200 200" class="w-full h-full relative z-10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" fill="white" fill-opacity="0.9" />
                        <rect x="60" y="70" width="80" height="70" stroke="#64748B" stroke-width="8" stroke-linejoin="round" />
                        <path d="M80 70V50C80 38.9543 88.9543 30 100 30C111.046 30 120 38.9543 120 50V70" stroke="#64748B" stroke-width="8" />
                        <circle cx="100" cy="105" r="10" fill="#64748B" />
                        <line x1="100" y1="115" x2="100" y2="125" stroke="#64748B" stroke-width="4" stroke-linecap="round" />
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-slate-900 mb-4">Pendaftaran Telah Selesai</h2>
                <p class="text-slate-600 max-w-lg mb-8">Gerbang pendaftaran telah ditutup. Pantau terus informasi pengumuman hasil seleksi di kanal resmi kami.</p>
                <a href="{{ route('contact') }}" data-spa="/spa/contact" class="px-8 py-4 bg-white border-2 border-blue-600 text-blue-600 rounded-full font-bold hover:bg-blue-50 transition shadow-lg">Hubungi Kami untuk Informasi Lanjut</a>
            </div>

        @else
            {{-- State: Open or Closing Soon --}}
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="reveal">
                    @if($status === 'closing_soon')
                        {{-- Segera Ditutup --}}
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3 text-red-700 animate-pulse">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="font-bold uppercase text-xs tracking-wider">Peringatan: Pendaftaran Segera Ditutup!</span>
                        </div>
                        <h2 class="text-4xl font-black text-slate-900 mb-6 leading-tight text-red-600">Kesempatan Terakhir!</h2>
                    @else
                        {{-- Mulai --}}
                        <h2 class="text-4xl font-black text-slate-900 mb-6 leading-tight">Pendaftaran Telah Dibuka!</h2>
                    @endif

                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">Silakan klik tombol di bawah untuk mengisi formulir pendaftaran. Pastikan Anda telah menyiapkan dokumen yang diperlukan.</p>
                    
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('ppdb.daftar') }}" data-spa="/spa/ppdb/daftar" class="group inline-flex items-center justify-center gap-3 px-8 py-5 bg-blue-600 text-white rounded-3xl font-bold text-xl shadow-2xl shadow-blue-600/30 hover:bg-blue-700 transition-all hover:-translate-y-1">
                            Daftar Sekarang
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <p class="text-sm text-slate-400 text-center font-medium">Batas pendaftaran: {{ $settings->end_date->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </div>

                <div class="reveal reveal-delay-2">
                    {{-- Banner Carousel or State Illustration --}}
                    @if($banners->count() > 0)
                        <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-8 border-white group">
                            <div class="aspect-[4/5] w-full bg-slate-200 relative">
                                @foreach($banners as $index => $banner)
                                    <div class="absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }} ppdb-banner" data-index="{{ $index }}">
                                        <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover" alt="{{ $banner->title }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="aspect-square rounded-[2.5rem] bg-gradient-to-br from-blue-100 to-white border-4 border-white shadow-xl flex items-center justify-center p-12">
                            @if($status === 'closing_soon')
                                <svg viewBox="0 0 200 200" class="w-full h-auto animate-pulse" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="100" cy="100" r="80" fill="#FEE2E2" />
                                    <path d="M100 40V100L130 130" stroke="#EF4444" stroke-width="12" stroke-linecap="round" />
                                    <circle cx="100" cy="100" r="10" fill="#EF4444" />
                                    <path d="M60 160C80 140 120 140 140 160" stroke="#EF4444" stroke-width="8" stroke-linecap="round" />
                                </svg>
                            @else
                                <svg viewBox="0 0 200 200" class="w-full h-auto animate-float" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="100" cy="100" r="90" fill="#DBEAFE" />
                                    <path d="M50 140V70C50 58.9543 58.9543 50 70 50H130C141.046 50 150 58.9543 150 70V140" stroke="#3B82F6" stroke-width="10" stroke-linecap="round" />
                                    <path d="M40 140H160" stroke="#3B82F6" stroke-width="12" stroke-linecap="round" />
                                    <circle cx="100" cy="95" r="20" fill="#60A5FA" />
                                </svg>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif

    </div>
</section>

<div class="flex flex-wrap gap-4 justify-center mb-16">
    <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full text-blue-600 font-bold hover:bg-blue-50 transition shadow-2xl hover:shadow-3xl text-lg">
        <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Beranda
    </a>
</div>
