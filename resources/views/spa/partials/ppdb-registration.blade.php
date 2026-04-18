{{-- PPDB Registration (Iframe) SPA Partial --}}

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-8 md:py-12 text-center">
        <h1 class="reveal font-display text-[clamp(1.5rem,4vw,2.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Formulir Pendaftaran
        </h1>
        <p class="reveal reveal-delay-1 mt-2 text-white/80 text-sm">Silakan lengkapi data calon siswa di bawah ini.</p>
    </div>
</section>

<section class="bg-slate-100 min-h-screen relative">
    {{-- Loading Overlay --}}
    <div id="form-loader" class="absolute inset-0 z-10 flex items-center justify-center bg-slate-50 transition-opacity duration-500">
        <div class="text-center">
            <div class="inline-block w-12 h-12 border-4 border-blue-600/20 border-t-blue-600 rounded-full animate-spin mb-4"></div>
            <p class="text-slate-500 font-bold animate-pulse">Menyiapkan formulir...</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200">
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
                        class="opacity-0 transition-opacity duration-700"
                        onload="handleIframeLoad()"
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

<script>
    function handleIframeLoad() {
        const iframe = document.getElementById('ppdb-iframe');
        const loader = document.getElementById('form-loader');
        if (iframe && loader) {
            iframe.classList.remove('opacity-0');
            loader.classList.add('opacity-0');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }
    }
</script>
