{{-- PPDB Registration (Iframe) SPA Partial --}}

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-8 md:py-12 text-center">
        <h1 class="reveal font-display text-[clamp(1.5rem,4vw,2.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Formulir Pendaftaran
        </h1>
        <p class="reveal reveal-delay-1 mt-2 text-white/80 text-sm">
            @if($status === 'closing_soon')
                <span class="px-3 py-1 rounded-full bg-red-500 text-white font-bold text-xs animate-pulse mr-2">Hampir Selesai</span>
            @endif
            Pendaftaran ditutup pada {{ $settings->end_date->translatedFormat('d F Y, H:i') }} WIB
        </p>
    </div>
</section>

<section class="bg-slate-100 min-h-screen relative" id="ppdb-reg-container"
         data-ppdb-end="{{ $settings->end_date ? $settings->end_date->toIso8601String() : '' }}">

    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200" id="iframe-wrapper">
            <div class="w-full relative" style="height: 1200px;">
                @if($settings->form_url)
                    <iframe 
                        id="ppdb-iframe"
                        src="{{ $settings->form_url }}" 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        marginheight="0" 
                        marginwidth="0"
                        class="w-full h-full"
                    >Memuat…</iframe>
                @else
                    <div class="flex items-center justify-center h-full text-slate-400">
                        Link formulir belum diatur oleh admin.
                    </div>
                @endif
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('ppdb') }}" data-spa="/spa/ppdb" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Batal dan Kembali
            </a>
        </div>
    </div>
</section>

{{-- Modal PPDB Ditutup Otomatis --}}
<div id="ppdb-closed-modal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4 bg-slate-900/90 backdrop-blur-md">
    <div class="bg-white rounded-[2.5rem] p-8 max-w-md w-full shadow-2xl text-center">
        <div class="w-24 h-24 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">Waktu Habis!</h3>
        <p class="text-slate-600 mb-8">Mohon maaf, pendaftaran PPDB SD N 2 Dermolo telah ditutup secara otomatis karena waktu pendaftaran telah berakhir.</p>
        <a href="{{ route('ppdb') }}" data-spa="/spa/ppdb" class="block w-full py-4 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
            Kembali ke Halaman PPDB
        </a>
    </div>
</div>
