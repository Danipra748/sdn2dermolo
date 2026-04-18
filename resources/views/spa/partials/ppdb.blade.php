@php use Carbon\Carbon; @endphp
{{-- PPDB Landing SPA Partial --}}

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

<section class="py-16 px-4 bg-slate-50 min-h-[600px]">
    <div class="max-w-6xl mx-auto">
        
        @if($status === 'waiting')
            {{-- State: Waiting --}}
            <div class="flex flex-col items-center text-center py-12 reveal">
                <div class="w-64 h-64 mb-8 animate-bounce-slow">
                    <img src="{{ asset('js/illustrations/waiting.svg') }}" onerror="this.src='https://illustrations.popsy.co/amber/waiting.svg'" alt="Waiting" class="w-full h-full object-contain">
                </div>
                <h2 class="text-3xl font-black text-slate-900 mb-4">Pendaftaran Belum Dimuka</h2>
                <p class="text-slate-600 max-w-lg mb-8">Sabar ya! Pendaftaran PPDB SD N 2 Dermolo akan segera dibuka pada tanggal:</p>
                <div class="bg-white px-8 py-4 rounded-3xl shadow-xl border border-blue-100 mb-8">
                    <div class="text-blue-600 font-black text-xl mb-1">{{ $settings->start_date->translatedFormat('d F Y') }}</div>
                    <div class="text-slate-400 text-sm font-bold uppercase tracking-widest">Pukul {{ $settings->start_date->format('H:i') }} WIB</div>
                </div>
                {{-- Countdown logic handled in spa.js --}}
                <div id="ppdb-countdown" data-until="{{ $settings->start_date->toIso8601String() }}" class="flex gap-4">
                    {{-- JS will inject items here --}}
                </div>
            </div>

        @elseif($status === 'closed')
            {{-- State: Closed --}}
            <div class="flex flex-col items-center text-center py-12 reveal">
                <div class="w-64 h-64 mb-8">
                    <img src="{{ asset('js/illustrations/closed.svg') }}" onerror="this.src='https://illustrations.popsy.co/blue/goodbye.svg'" alt="Closed" class="w-full h-full object-contain grayscale opacity-80">
                </div>
                <h2 class="text-3xl font-black text-slate-900 mb-4">Pendaftaran Telah Ditutup</h2>
                <p class="text-slate-600 max-w-lg mb-8">Terima kasih atas antusiasme Anda. Masa pendaftaran PPDB SD N 2 Dermolo telah berakhir.</p>
                <a href="{{ route('contact') }}" data-spa="/spa/contact" class="px-8 py-4 bg-white border-2 border-blue-600 text-blue-600 rounded-full font-bold hover:bg-blue-50 transition shadow-lg">Hubungi Kami untuk Info Lanjut</a>
            </div>

        @else
            {{-- State: Open or Closing Soon --}}
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="reveal">
                    @if($status === 'closing_soon')
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-center gap-3 text-red-700 animate-pulse">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="font-bold">Pendaftaran akan segera ditutup! Selesaikan sebelum {{ $settings->end_date->translatedFormat('d F, H:i') }} WIB</span>
                        </div>
                    @endif

                    <h2 class="text-4xl font-black text-slate-900 mb-6 leading-tight">Pendaftaran Kini Dibuka!</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">Jangan lewatkan kesempatan untuk bergabung menjadi bagian dari keluarga besar SD N 2 Dermolo. Klik tombol di bawah untuk mengisi formulir pendaftaran secara online.</p>
                    
                    <div class="flex flex-col gap-4">
                        <a href="{{ route('ppdb.daftar') }}" data-spa="/spa/ppdb/daftar" class="group inline-flex items-center justify-center gap-3 px-8 py-5 bg-blue-600 text-white rounded-3xl font-bold text-xl shadow-2xl shadow-blue-600/30 hover:bg-blue-700 transition-all hover:-translate-y-1">
                            Daftar Sekarang
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <p class="text-sm text-slate-400 text-center">Pastikan data yang Anda masukkan sudah benar dan sesuai.</p>
                    </div>

                    <div class="mt-12 grid grid-cols-2 gap-6">
                        <div class="p-5 bg-white rounded-2xl shadow-sm border border-slate-200">
                            <div class="text-blue-600 font-bold mb-1">Mudah</div>
                            <div class="text-xs text-slate-500">Pendaftaran 100% online dari rumah.</div>
                        </div>
                        <div class="p-5 bg-white rounded-2xl shadow-sm border border-slate-200">
                            <div class="text-green-600 font-bold mb-1">Cepat</div>
                            <div class="text-xs text-slate-500">Proses pengisian formulir kurang dari 10 menit.</div>
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-delay-2">
                    {{-- Banner Carousel --}}
                    @if($banners->count() > 0)
                        <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-8 border-white group">
                            <div class="aspect-[4/5] w-full bg-slate-200 relative">
                                @foreach($banners as $index => $banner)
                                    <div class="absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }} ppdb-banner" data-index="{{ $index }}">
                                        <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover" alt="{{ $banner->title }}">
                                        @if($banner->title)
                                            <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/80 to-transparent text-white">
                                                <div class="font-bold text-lg">{{ $banner->title }}</div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            {{-- Carousel Navigation --}}
                            @if($banners->count() > 1)
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                                    @foreach($banners as $index => $banner)
                                        <button class="w-2.5 h-2.5 rounded-full bg-white/40 transition-all ppdb-dot {{ $index === 0 ? 'bg-white scale-125' : '' }}" data-index="{{ $index }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="aspect-[4/5] rounded-[2.5rem] bg-gradient-to-br from-blue-100 to-blue-50 border-4 border-white shadow-xl flex items-center justify-center p-12">
                            <img src="{{ asset('js/illustrations/school.svg') }}" onerror="this.src='https://illustrations.popsy.co/blue/school-admission.svg'" alt="PPDB" class="w-full h-auto">
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
