{{-- ===== CONTACT SPA PARTIAL ===== --}}

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <x-heroicon-o-phone class="h-4 w-4" /> KONTAK KAMI
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Hubungi Kami
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Kami siap melayani informasi terkait pendaftaran, program sekolah, dan kerjasama lainnya.
        </p>
    </div>
</section>

<section id="kontak" class="section px-6 pb-20 pt-16 bg-slate-50">
    <div class="section-inner mx-auto max-w-[1200px]">
        <div class="kontak-grid grid grid-cols-[repeat(auto-fit,minmax(260px,1fr))] gap-6">
            <div class="kontak-card kontak-card-blue reveal relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white p-6 text-left shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] before:absolute before:inset-0 before:bg-gradient-to-br before:from-blue-600/6 before:to-blue-500/6 before:opacity-0 before:transition-opacity before:duration-[350ms] hover:before:opacity-100">
                <div class="kontak-icon mb-4 flex h-11 w-11 items-center justify-center rounded-[0.85rem] border border-slate-900/8 text-xl" style="background: rgba(26,86,219,0.1);">
                    <x-heroicon-o-map-pin class="h-5 w-5 text-blue-600" />
                </div>
                <div class="kontak-meta mb-2 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-slate-400">Alamat Sekolah</div>
                <div class="kontak-body rounded-[0.9rem] border border-slate-200 bg-slate-50 p-4">
                    <h3 class="mb-1 text-[1.05rem] font-black text-slate-900">Alamat</h3>
                    <p>{!! $alamatLines->implode('<br>') !!}</p>
                </div>
            </div>
            <div class="kontak-card kontak-card-green reveal reveal-delay-1 relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white p-6 text-left shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] before:absolute before:inset-0 before:bg-gradient-to-br before:from-emerald-600/4 before:to-emerald-400/4 before:opacity-0 before:transition-opacity before:duration-[350ms] hover:before:opacity-100">
                <div class="kontak-icon mb-4 flex h-11 w-11 items-center justify-center rounded-[0.85rem] border border-slate-900/8 text-xl" style="background: rgba(16,185,129,0.1);">
                    <x-heroicon-o-phone class="h-5 w-5 text-emerald-600" />
                </div>
                <div class="kontak-meta mb-2 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-slate-400">Kontak Cepat</div>
                <div class="kontak-body rounded-[0.9rem] border border-slate-200 bg-slate-50 p-4">
                    @if($kontak['phone'])
                    <p class="mb-2 text-slate-700">
                        <span class="mr-1">Tel:</span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $kontak['phone']) }}" class="hover:text-blue-600">{{ $kontak['phone'] }}</a>
                    </p>
                    @endif
                    @if($kontak['email'])
                    <p class="text-slate-700">
                        <span class="mr-1">Email:</span>
                        <a href="mailto:{{ $kontak['email'] }}" class="hover:text-blue-600">{{ $kontak['email'] }}</a>
                    </p>
                    @endif
                </div>
            </div>
            <div class="kontak-card kontak-card-purple reveal reveal-delay-2 relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white p-6 text-left shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] before:absolute before:inset-0 before:bg-gradient-to-br before:from-violet-600/4 before:to-violet-400/4 before:opacity-0 before:transition-opacity before:duration-[350ms] hover:before:opacity-100">
                <div class="kontak-icon mb-4 flex h-11 w-11 items-center justify-center rounded-[0.85rem] border border-slate-900/8 text-xl" style="background: rgba(124,58,237,0.1);">
                    <x-heroicon-o-clock class="h-5 w-5 text-violet-600" />
                </div>
                <div class="kontak-meta mb-2 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-slate-400">Informasi</div>
                <div class="kontak-body rounded-[0.9rem] border border-slate-200 bg-slate-50 p-4">
                    <p class="mb-2 text-slate-700">07:00 - 14:00 WIB</p>
                    <p class="text-slate-700">Senin - Jumat</p>
                </div>
            </div>
        </div>

        <div class="kontak-extra reveal mt-10 grid grid-cols-1 gap-6 md:grid-cols-[1.2fr_0.8fr]">
            @include('partials.school-map-embed')
            <div class="rounded-[1.25rem] border border-slate-200 bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,0.08),0_1px_2px_rgba(0,0,0,0.06)]">
                <h3 class="text-xl font-black text-slate-900">Formulir Saran</h3>
                <p class="mt-2 text-[0.92rem] leading-[1.6] text-slate-500">
                    Kami menghargai masukan Anda. Silakan isi formulir di bawah ini untuk memberikan saran atau pertanyaan.
                </p>
                <form action="{{ route('contact-messages.store') }}" method="POST" class="mt-5 space-y-4">
                    @csrf
                    <input type="hidden" name="subject" value="Pesan dari Kontak Website">
                    <div>
                        <label for="nama" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="name" 
                            required
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        />
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            placeholder="contoh@email.com"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        />
                    </div>
                    <div>
                        <label for="pesan" class="mb-1.5 block text-sm font-semibold text-slate-700">Pesan/Saran</label>
                        <textarea 
                            id="pesan" 
                            name="message" 
                            rows="5" 
                            required
                            placeholder="Tulis saran atau pertanyaan Anda di sini..."
                            class="w-full resize-none rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        ></textarea>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full rounded-lg bg-blue-600 px-6 py-3 text-base font-bold text-white shadow-lg shadow-blue-600/30 transition-all duration-200 hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/40 hover:-translate-y-0.5 active:translate-y-0 active:shadow-md"
                    >
                        Kirim Saran
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>
