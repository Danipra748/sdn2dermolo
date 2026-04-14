{{-- Data Guru SPA Partial --}}
<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> TIM PENGAJAR
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Data Guru & Tenaga Kependidikan
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Profil tenaga pendidik yang profesional dan berdedikasi tinggi di SD N 2 Dermolo.
        </p>
    </div>
</section>

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        @if ($kepsek)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm reveal">
                <div class="flex flex-col md:flex-row md:items-center gap-5">
                    <div class="h-20 w-20 rounded-full bg-slate-900 text-white flex items-center justify-center text-3xl overflow-hidden">
                        @if ($kepsek->photo)
                            <img src="{{ asset('storage/' . $kepsek->photo) }}" alt="{{ $kepsek->nama }}"
                                 class="w-full h-full object-cover object-center">
                        @else
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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

        @php
        $guruColors = [
            ['avatar' => 'linear-gradient(135deg,#1a56db,#3b82f6)', 'jabatan' => '#2563eb'],
            ['avatar' => 'linear-gradient(135deg,#059669,#34d399)', 'jabatan' => '#059669'],
            ['avatar' => 'linear-gradient(135deg,#d97706,#fbbf24)', 'jabatan' => '#d97706'],
            ['avatar' => 'linear-gradient(135deg,#7c3aed,#a78bfa)', 'jabatan' => '#7c3aed'],
            ['avatar' => 'linear-gradient(135deg,#dc2626,#f87171)', 'jabatan' => '#dc2626'],
        ];
        @endphp

        <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($guruLain as $i => $g)
                @php $gc = $guruColors[$i % count($guruColors)]; @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-7 text-center shadow-sm reveal transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-[6px] hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)] hover:border-slate-300" style="transition-delay: {{ $i * 0.08 }}s;">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-[1.75rem] mx-auto mb-4" style="background: {{ $gc['avatar'] }};">
                        @if ($g->photo)
                            <img src="{{ asset('storage/' . $g->photo) }}" alt="{{ $g->nama }}"
                                 class="w-full h-full rounded-full object-cover object-center">
                        @else
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @endif
                    </div>
                    <div class="font-bold text-slate-900 text-[0.95rem] mb-1">{{ $g->nama }}</div>
                    <div class="text-[0.85rem] font-semibold" style="color: {{ $gc['jabatan'] }};">{{ $g->gr_kls_mp ?? $g->jabatan }}</div>
                </div>
            @empty
                <div class="col-span-full text-slate-500 text-center py-12">Data guru belum tersedia.</div>
            @endforelse
        </div>
    </div>
</section>
<div class="flex flex-wrap gap-4 justify-center mb-16">
    <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full  text-blue-600 font-bold hover:bg-blue-50 transition shadow-2xl hover:shadow-3xl text-lg">
                <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
    </a>
</div>