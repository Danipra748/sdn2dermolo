{{-- Program SPA Partial --}}
<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg> PROGRAM MINAT BAKAT
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Ekstrakurikuler
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Pilihan kegiatan untuk mengembangkan bakat, minat, dan karakter siswa di luar jam pelajaran.
        </p>
    </div>
</section>

<section class="py-12 px-4 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($program as $item)
                @php
                    $isObj = is_object($item);
                    $title = $isObj ? $item->title : ($item['title'] ?? 'Program');
                    $desc  = $isObj
                        ? ($item->desc ?? $item->description ?? '')
                        : ($item['desc'] ?? $item['description'] ?? '');
                    $logo  = $isObj ? ($item->logo ?? null) : null;
                    $foto  = $isObj ? ($item->foto ?? null) : ($item['foto'] ?? null);
                    $cardBg = $isObj ? ($item->card_bg_image ?? null) : ($item['card_bg_image'] ?? null);
                    $slug  = $isObj ? ($item->slug ?? null) : null;

                    $colorKey = $isObj
                        ? match ($slug) { 'pramuka' => 'blue', 'seni-ukir' => 'green', 'drumband' => 'yellow', default => 'blue' }
                        : ($item['color'] ?? 'blue');

                    $gradients = [
                        'blue' => 'linear-gradient(135deg, #1a56db, #3b82f6)',
                        'green' => 'linear-gradient(135deg, #059669, #34d399)',
                        'yellow' => 'linear-gradient(135deg, #d97706, #fbbf24)',
                    ];
                    $gradient = $gradients[$colorKey] ?? $gradients['blue'];
                @endphp
                @php
                    $routeName = $slug ? 'program.' . $slug : null;
                    $link = $routeName ? route($routeName) : '#';
                @endphp
                <a href="{{ $link }}"
                   class="group block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm reveal transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-[6px] hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)] hover:border-slate-300"
                   style="transition-delay: {{ $loop->index * 0.08 }}s;">
                    @php
                        $bgStyle = !empty($cardBg)
                            ? "background-image: url('" . asset('storage/' . $cardBg) . "'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                            : '';
                    @endphp
                    <div class="h-48 flex items-center justify-center relative overflow-hidden"
                         style="background: {{ $gradient }}; {{ $bgStyle }}">
                        @if (empty($cardBg))
                            @if (!empty($logo))
                                <img src="{{ asset('storage/' . $logo) }}" alt="Logo {{ $title }}"
                                     class="w-full h-full object-cover">
                            @elseif (!empty($foto))
                                <img src="{{ asset('storage/' . $foto) }}" alt="{{ $title }}"
                                     class="w-full h-full object-contain p-4">
                            @else
                                <span class="text-3xl text-white font-bold">{{ strtoupper(substr($title, 0, 1)) }}</span>
                            @endif
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-slate-900 text-lg">{{ $title }}</h3>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 shadow-xl">
                        <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <p class="text-slate-500 text-lg font-semibold">Belum ada data program</p>
                        <p class="text-slate-400 text-sm mt-2 mb-8">Program dan ekstrakurikuler akan ditampilkan di sini setelah ditambahkan</p>

                        <a href="{{ route('home') }}" data-spa="/spa/home" data-spa-title="Beranda - SD N 2 Dermolo" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full text-blue-600 font-bold hover:bg-blue-50 transition shadow-lg text-base">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        </div>
        </section>