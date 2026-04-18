@php use Carbon\Carbon; @endphp
{{-- PPDB Landing SPA Partial --}}

<style>
    /* ── Core Keyframes ────────────────────────────── */
    @keyframes float-kid      { 0%,100%{ transform:translateY(0) }        50%{ transform:translateY(-7px) } }
    @keyframes star-twinkle   { 0%,100%{ opacity:1; transform:scale(1) }  50%{ opacity:.15; transform:scale(.4) } }
    @keyframes cloud-drift    { from{ transform:translateX(-10px) }        to{ transform:translateX(10px) } }
    @keyframes lantern-sway   { 0%,100%{ transform:rotate(-6deg) }         50%{ transform:rotate(6deg) } }
    @keyframes lantern-glow   { 0%,100%{ opacity:.7 }                      50%{ opacity:1 } }
    @keyframes kid-blink      { 0%,88%,100%{ transform:scaleY(1) }         93%{ transform:scaleY(.05) } }
    @keyframes kite-fly       { 0%{ transform:translate(0,0) rotate(-8deg) } 33%{ transform:translate(14px,-18px) rotate(-4deg) } 66%{ transform:translate(-6px,-9px) rotate(-12deg) } 100%{ transform:translate(0,0) rotate(-8deg) } }
    @keyframes balloon-rise   { 0%{ transform:translateY(0) rotate(-2deg) } 25%{ transform:translateY(-10px) rotate(2deg) } 50%{ transform:translateY(-16px) rotate(-1deg) } 75%{ transform:translateY(-10px) rotate(3deg) } 100%{ transform:translateY(0) rotate(-2deg) } }
    @keyframes sun-spin       { from{ transform:rotate(0deg) }              to{ transform:rotate(360deg) } }
    @keyframes grass-wave     { 0%,100%{ transform:rotate(-4deg) }          50%{ transform:rotate(4deg) } }
    @keyframes arm-wave       { 0%,100%{ transform:rotate(0deg) }           50%{ transform:rotate(-32deg) } }
    @keyframes rain-fall      { from{ transform:translateY(-24px); opacity:0 } to{ transform:translateY(360px); opacity:.7 } }
    @keyframes sign-swing     { 0%,100%{ transform:rotate(-6deg) }          50%{ transform:rotate(6deg) } }
    @keyframes chain-shake    { 0%,100%{ transform:translateX(0) } 20%{ transform:translateX(-3px) } 40%{ transform:translateX(3px) } 60%{ transform:translateX(-1.5px) } 80%{ transform:translateX(1.5px) } }
    @keyframes sad-blink      { 0%,85%,100%{ transform:scaleY(1) }          90%{ transform:scaleY(.06) } }
    @keyframes confetti-burst { 0%{ opacity:1; transform:translate(0,0) scale(1) rotate(0) } 100%{ opacity:0; transform:translate(var(--cx),var(--cy)) scale(.3) rotate(540deg) } }
    @keyframes pulse-ring-w   { 0%,100%{ transform:scale(.9); opacity:.4 }  50%{ transform:scale(1.1); opacity:.12 } }
    @keyframes pulse-btn      { 0%{ box-shadow:0 0 0 0 rgba(245,158,11,.5) } 70%{ box-shadow:0 0 0 18px rgba(245,158,11,0) } 100%{ box-shadow:0 0 0 0 rgba(245,158,11,0) } }

    /* ── Animation classes ─────────────────────────── */
    .ppdb-star       { animation: star-twinkle var(--d,2s) var(--dl,0s) ease-in-out infinite }
    .ppdb-cloud      { animation: cloud-drift 5s ease-in-out infinite alternate }
    .ppdb-lantern    { transform-origin: 200px 108px; animation: lantern-sway 3.2s ease-in-out infinite }
    .ppdb-lantern-gw { animation: lantern-glow 2.4s ease-in-out infinite }
    .ppdb-kid-eyes   { transform-origin: 200px 200px; animation: kid-blink 5s infinite }
    .ppdb-kid-body   { animation: float-kid 4s ease-in-out infinite }
    .ppdb-kite       { animation: kite-fly 5s ease-in-out infinite }
    .ppdb-b1         { animation: balloon-rise 3.2s ease-in-out infinite }
    .ppdb-b2         { animation: balloon-rise 4s   ease-in-out .6s  infinite }
    .ppdb-b3         { animation: balloon-rise 3.6s ease-in-out 1.2s infinite }
    .ppdb-b4         { animation: balloon-rise 4.4s ease-in-out .3s  infinite }
    .ppdb-sun-rays   { animation: sun-spin 12s linear infinite; transform-origin: 56px 56px }
    .ppdb-grass      { animation: grass-wave 2s ease-in-out infinite; transform-origin: bottom center }
    .ppdb-grass:nth-child(2n)  { animation-delay: .4s }
    .ppdb-arm-wave   { animation: arm-wave 1.2s ease-in-out infinite; transform-origin: 252px 246px }
    .ppdb-rain       { animation: rain-fall var(--d,1.1s) var(--dl,0s) linear infinite }
    .ppdb-sign       { transform-origin: 174px 68px; animation: sign-swing 3.5s ease-in-out infinite }
    .ppdb-chain      { transform-origin: 174px 218px; animation: chain-shake 4s ease-in-out 2s infinite }
    .ppdb-sad-eyes   { transform-origin: 174px 175px; animation: sad-blink 6s infinite }
    .ppdb-pulse-ring { animation: pulse-ring-w 4s ease-in-out infinite }
    .ppdb-balloon    { cursor: pointer; transition: transform .15s, filter .15s }
    .ppdb-balloon:hover  { filter: brightness(1.14) }
    .ppdb-balloon:active { transform: scale(.9) }
    .ppdb-pulse-btn  { animation: pulse-btn 2s infinite }

    /* ── Countdown boxes ───────────────────────────── */
    .ppdb-cd-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }
    .ppdb-cd-box {
        background: #fff;
        border: 2px solid #dbeafe;
        border-radius: 14px;
        padding: 14px 12px 10px;
        text-align: center;
        min-width: 64px;
        flex: 1 1 64px;
        max-width: 90px;
        box-shadow: 0 4px 16px rgba(30,58,138,.08);
    }
    .ppdb-cd-num   { font-size: 1.85rem; font-weight: 900; color: #1d4ed8; line-height: 1 }
    .ppdb-cd-lbl   { font-size: 9px; font-weight: 800; color: #94a3b8; letter-spacing: .14em; margin-top: 4px; text-transform: uppercase }

    /* ── Open-state two-column grid ────────────────── */
    .ppdb-open-grid { display: grid; grid-template-columns: 1fr; gap: 2.5rem }
    @media (min-width: 1024px) {
        .ppdb-open-grid { grid-template-columns: 1fr 1fr; gap: 5rem }
    }
    /* On < lg: illustration floats above the CTA */
    @media (max-width: 1023px) {
        .ppdb-illus-col { order: -1 }
    }

    /* ── Feature cards ─────────────────────────────── */
    .ppdb-feature-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px }
    @media (max-width: 400px) {
        .ppdb-feature-grid { gap: 8px }
        .ppdb-feature-card { padding: 12px !important }
        .ppdb-cd-num { font-size: 1.5rem }
        .ppdb-cd-box { min-width: 56px; padding: 10px 8px 8px }
    }
</style>

{{-- ═══════════════════════════════════════════
     HERO SECTION WITH INFINITE LOOP
══════════════════════════════════════════════ --}}
<section class="relative overflow-hidden text-white"
         style="padding-top:80px; min-height: 480px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    
    {{-- Background Slideshow --}}
    <div class="absolute inset-0 z-0">
        @if($banners->count() > 0)
            @foreach($banners as $index => $banner)
                <div class="ppdb-hero-bg absolute inset-0 transition-opacity duration-[2000ms] ease-in-out {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                     data-index="{{ $index }}">
                    <img src="{{ asset('storage/' . $banner->image_path) }}" 
                         class="w-full h-full object-cover" 
                         alt="Background {{ $index }}"
                         loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                </div>
            @endforeach
            {{-- Persistent Blue Overlay (Stable & No Flickering) --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#1e3a8a]/95 via-[#1e40af]/90 to-[#0ea5e9]/85 backdrop-blur-[1px]"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-[#1e3a8a] via-[#1e40af] to-[#0ea5e9]"></div>
        @endif
    </div>

    <div class="mx-auto max-w-[1200px] px-5 sm:px-8 py-16 md:py-24 text-center relative z-10 h-full flex flex-col justify-center items-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold tracking-wide text-white backdrop-blur-md shadow-2xl">
            <x-heroicon-o-sparkles class="h-4 w-4 text-amber-400 flex-shrink-0" />
            PPDB ONLINE SDN 2 DERMOLO
        </div>
        <h1 class="reveal reveal-delay-1 mt-8 font-display text-[clamp(2.4rem,6vw,4.5rem)] font-black leading-[1.05] tracking-tight text-white drop-shadow-[0_4px_12px_rgba(0,0,0,0.3)]">
            Penerimaan Peserta <br class="hidden sm:block"> Didik Baru
        </h1>
        <p class="reveal reveal-delay-2 mt-6 text-center max-w-[700px] mx-auto text-[clamp(1.05rem,2vw,1.25rem)] leading-[1.8] text-white/95 px-2 drop-shadow-md font-medium">
            Selamat datang di layanan pendaftaran mandiri calon siswa baru. Mari bergabung bersama keluarga besar SD N 2 Dermolo.
        </p>
    </div>
    
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/5 rounded-full blur-3xl opacity-40 pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-sky-400/10 rounded-full blur-3xl opacity-40 pointer-events-none"></div>
</section>

{{-- ═══════════════════════════════════════════
     MAIN STATE SECTION
══════════════════════════════════════════════ --}}
<section class="py-14 sm:py-20 px-5 sm:px-8 bg-slate-50 relative overflow-hidden"
         id="ppdb-main-container"
         data-ppdb-state="{{ $status }}"
         data-ppdb-start="{{ $settings->start_date ? $settings->start_date->toIso8601String() : '' }}"
         data-ppdb-end="{{ $settings->end_date ? $settings->end_date->toIso8601String() : '' }}">

    <div class="max-w-[1200px] mx-auto relative z-10">

    {{-- ─────────────────────────────────────────
         STATE 1 : WAITING
    ──────────────────────────────────────────── --}}
    @if($status === 'waiting')
        <div class="flex flex-col items-center text-center reveal">

            {{-- Illustration --}}
            <div class="relative mb-10 sm:mb-12 w-full" style="max-width:290px;margin-left:auto;margin-right:auto">
                <div class="ppdb-pulse-ring absolute inset-0 rounded-full bg-amber-400/20 pointer-events-none"></div>
                <svg viewBox="0 0 340 340" width="100%" fill="none" xmlns="http://www.w3.org/2000/svg" class="relative z-10">
                    <rect width="340" height="340" rx="28" fill="#0f172a"/>
                    <circle class="ppdb-star" style="--d:2.1s;--dl:0s"   cx="40"  cy="30" r="1.5" fill="#fde68a"/>
                    <circle class="ppdb-star" style="--d:1.8s;--dl:.3s"  cx="90"  cy="18" r="2"   fill="#fff"/>
                    <circle class="ppdb-star" style="--d:2.5s;--dl:.6s"  cx="145" cy="25" r="1.3" fill="#bfdbfe"/>
                    <circle class="ppdb-star" style="--d:2.2s;--dl:.9s"  cx="200" cy="14" r="1.8" fill="#fde68a"/>
                    <circle class="ppdb-star" style="--d:1.9s;--dl:.2s"  cx="260" cy="32" r="1.5" fill="#fff"/>
                    <circle class="ppdb-star" style="--d:2.4s;--dl:.7s"  cx="305" cy="20" r="2"   fill="#bfdbfe"/>
                    <circle class="ppdb-star" style="--d:2s;--dl:1.1s"   cx="320" cy="60" r="1.2" fill="#fde68a"/>
                    <circle class="ppdb-star" style="--d:1.7s;--dl:.4s"  cx="20"  cy="80" r="1.5" fill="#fff"/>
                    <circle class="ppdb-star" style="--d:2.3s;--dl:1.3s" cx="68"  cy="70" r="1"   fill="#bfdbfe"/>
                    <circle class="ppdb-star" style="--d:2.1s;--dl:.8s"  cx="170" cy="55" r="1.5" fill="#fde68a"/>
                    <circle class="ppdb-star" style="--d:1.6s;--dl:1.5s" cx="285" cy="74" r="1.2" fill="#fff"/>
                    <circle cx="282" cy="58" r="38" fill="none" stroke="#fde68a" stroke-width="1" opacity=".14">
                        <animate attributeName="r"       values="38;48;38"       dur="4s" repeatCount="indefinite"/>
                        <animate attributeName="opacity" values=".14;.04;.14" dur="4s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="282" cy="58" r="28" fill="#fef3c7"/>
                    <circle cx="294" cy="50" r="22" fill="#0f172a"/>
                    <g class="ppdb-cloud" opacity=".12">
                        <ellipse cx="80"  cy="110" rx="38" ry="16" fill="#fff"/>
                        <ellipse cx="58"  cy="114" rx="22" ry="12" fill="#fff"/>
                        <ellipse cx="106" cy="114" rx="20" ry="11" fill="#fff"/>
                    </g>
                    <rect x="0" y="278" width="340" height="62" fill="#1e3a5f"/>
                    <rect x="0" y="292" width="340" height="48" fill="#1e3a8a"/>
                    <rect x="60" y="232" width="220" height="60" fill="#0f172a" opacity=".6"/>
                    <polygon points="60,232 174,186 288,232" fill="#0f172a" opacity=".6"/>
                    <rect x="152" y="242" width="44" height="50" fill="#0f172a"/>
                    <g class="ppdb-kid-body">
                        <rect x="159" y="238" width="30" height="38" rx="15" fill="#3b82f6"/>
                        <rect x="162" y="272" width="10" height="22" rx="5"  fill="#1e40af"/>
                        <rect x="176" y="272" width="10" height="22" rx="5"  fill="#1e40af"/>
                        <ellipse cx="167" cy="294" rx="8"  ry="5" fill="#0f172a"/>
                        <ellipse cx="181" cy="294" rx="8"  ry="5" fill="#0f172a"/>
                        <rect x="140" y="240" width="22" height="10" rx="5" fill="#fcd5ae" transform="rotate(20,151,245)"/>
                        <rect x="186" y="240" width="22" height="10" rx="5" fill="#fcd5ae" transform="rotate(-10,197,245)"/>
                        <rect x="169" y="224" width="10" height="16" rx="4" fill="#fcd5ae"/>
                        <circle cx="174" cy="211" r="22" fill="#fcd5ae"/>
                        <path d="M152 203C152 190 159 183 174 182C189 181 196 190 196 203" fill="#7c3aed"/>
                        <ellipse cx="174" cy="182" rx="14" ry="8" fill="#7c3aed"/>
                        <g class="ppdb-kid-eyes">
                            <circle cx="167" cy="210" r="3.5" fill="#0f172a"/>
                            <circle cx="181" cy="210" r="3.5" fill="#0f172a"/>
                            <circle cx="168.2" cy="209" r="1.2" fill="#fff"/>
                            <circle cx="182.2" cy="209" r="1.2" fill="#fff"/>
                        </g>
                        <path d="M167 218 Q174 224 181 218" stroke="#c47a4a" stroke-width="2" stroke-linecap="round" fill="none"/>
                        <circle cx="162" cy="216" r="5" fill="#fca5a5" opacity=".5"/>
                        <circle cx="186" cy="216" r="5" fill="#fca5a5" opacity=".5"/>
                    </g>
                    <g class="ppdb-lantern">
                        <line x1="174" y1="98"  x2="174" y2="162" stroke="#fde68a" stroke-width="1" opacity=".6"/>
                        <rect x="159" y="162" width="30" height="40" rx="8"  fill="#f59e0b"/>
                        <rect x="159" y="162" width="30" height="40" rx="8"  fill="#fbbf24" opacity=".35"/>
                        <rect x="162" y="165" width="24" height="34" rx="6"  fill="#fde68a" class="ppdb-lantern-gw" opacity=".7"/>
                        <line x1="174" y1="166" x2="174" y2="198" stroke="#d97706" stroke-width="1.5"/>
                        <line x1="161" y1="182" x2="187" y2="182" stroke="#d97706" stroke-width="1.5"/>
                        <circle cx="174" cy="182" r="24" fill="#fde68a" class="ppdb-lantern-gw" opacity=".07"/>
                    </g>
                    <text x="174" y="150" text-anchor="middle" font-family="sans-serif" font-size="11" font-weight="700" fill="#fde68a" letter-spacing="3" opacity=".75">SEGERA DIMULAI</text>
                </svg>
            </div>

            {{-- Badge --}}
            <span class="inline-block px-5 py-2 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold tracking-wide">
                SEGERA DIMULAI
            </span>

            {{-- Heading & subtext --}}
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mt-5 mb-3 px-4 leading-snug">
                Persiapkan Berkas Anda!
            </h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-sm px-4 mb-10 sm:mb-12">
                PPDB segera dibuka. Siapkan dokumen yang diperlukan agar proses pendaftaran berjalan lancar.
            </p>

            {{-- Countdown card --}}
            <div class="w-full max-w-md sm:max-w-lg bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
                <div class="px-6 sm:px-8 pt-7 pb-5 border-b border-slate-100 text-center">
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-[.2em]">Dibuka pada</span>
                    <div class="text-blue-600 font-black text-xl sm:text-2xl mt-2 leading-tight">
                        {{ $settings->start_date->translatedFormat('d F Y') }}
                    </div>
                    <div class="text-slate-500 font-medium text-sm mt-1">
                        Pukul {{ $settings->start_date->format('H:i') }} WIB
                    </div>
                </div>
                <div class="px-6 sm:px-8 py-7">
                    <div id="ppdb-countdown" data-until="{{ $settings->start_date->toIso8601String() }}" class="ppdb-cd-row">
                        @foreach(['d'=>'Hari','h'=>'Jam','m'=>'Menit','s'=>'Detik'] as $unit => $label)
                            <div class="ppdb-cd-box">
                                <div class="ppdb-cd-num" id="cd-{{ $unit }}">--</div>
                                <div class="ppdb-cd-lbl">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    {{-- ─────────────────────────────────────────
         STATE 2 : CLOSED
    ──────────────────────────────────────────── --}}
    @elseif($status === 'closed')
        <div class="flex flex-col items-center text-center reveal">

            {{-- Illustration --}}
            <div class="relative mb-10 sm:mb-12 w-full" style="max-width:260px;margin-left:auto;margin-right:auto">
                <svg viewBox="0 0 340 340" width="100%" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="340" height="340" rx="28" fill="#94a3b8"/>
                    <ellipse cx="170" cy="55"  rx="120" ry="50" fill="#64748b"/>
                    <ellipse cx="72"  cy="72"  rx="70"  ry="40" fill="#64748b"/>
                    <ellipse cx="272" cy="65"  rx="80"  ry="38" fill="#64748b"/>
                    <ellipse cx="170" cy="38"  rx="100" ry="34" fill="#475569"/>
                    @php $rainDrops = [
                        [38,80,1.1,0],[78,70,1.3,.2],[118,85,.9,.4],[163,75,1.2,.1],
                        [208,80,1.0,.6],[250,72,1.4,.3],[294,78,1.1,.5],[58,134,.85,.15],
                        [138,122,1.25,.45],[228,127,1.05,.35],[308,118,.95,.75],[183,142,1.15,.65],
                        [26,105,.88,.25],[105,155,1.18,.55],[265,148,.92,.38],
                    ]; @endphp
                    <g stroke="#bfdbfe" stroke-width="1.5" stroke-linecap="round" opacity=".6">
                        @foreach($rainDrops as [$rx,$ry,$rd,$rdl])
                            <line class="ppdb-rain" style="--d:{{ $rd }}s;--dl:{{ $rdl }}s" x1="{{ $rx }}" y1="{{ $ry }}" x2="{{ $rx-4 }}" y2="{{ $ry+18 }}"/>
                        @endforeach
                    </g>
                    <ellipse cx="110" cy="322" rx="40" ry="8" fill="#64748b" opacity=".4"/>
                    <ellipse cx="235" cy="318" rx="30" ry="6" fill="#64748b" opacity=".4"/>
                    <rect x="0" y="292" width="340" height="48" fill="#334155"/>
                    <rect x="86" y="208" width="168" height="90" rx="4" fill="#cbd5e1" opacity=".5"/>
                    <rect x="86" y="208" width="168" height="22" fill="#94a3b8" opacity=".5"/>
                    <polygon points="76,212 170,162 264,212" fill="#e2e8f0" opacity=".5"/>
                    <rect x="105" y="224" width="32" height="22" rx="4" fill="#94a3b8" opacity=".3"/>
                    <rect x="203" y="224" width="32" height="22" rx="4" fill="#94a3b8" opacity=".3"/>
                    <rect x="130" y="220" width="80" height="102" rx="8" fill="#334155"/>
                    <rect x="135" y="225" width="70" height="92"  rx="6" fill="#475569"/>
                    <rect x="140" y="230" width="28" height="38"  rx="4" fill="#334155"/>
                    <rect x="172" y="230" width="28" height="38"  rx="4" fill="#334155"/>
                    <rect x="140" y="273" width="28" height="36"  rx="4" fill="#334155"/>
                    <rect x="172" y="273" width="28" height="36"  rx="4" fill="#334155"/>
                    <g class="ppdb-chain">
                        <rect x="154" y="248" width="32" height="26" rx="6" fill="#64748b"/>
                        <path d="M158 248 C158 234 186 234 186 248" stroke="#94a3b8" stroke-width="7" stroke-linecap="round" fill="none"/>
                        <circle cx="170" cy="261" r="5" fill="#94a3b8"/>
                        <rect x="168" y="263" width="4" height="7" rx="2" fill="#64748b"/>
                    </g>
                    <g class="ppdb-sign">
                        <line x1="154" y1="66" x2="154" y2="84" stroke="#64748b" stroke-width="2.5"/>
                        <line x1="186" y1="66" x2="186" y2="84" stroke="#64748b" stroke-width="2.5"/>
                        <rect x="134" y="84" width="72" height="34" rx="8" fill="#ef4444"/>
                        <text x="170" y="106" text-anchor="middle" font-family="sans-serif" font-size="13" font-weight="700" fill="#fff" letter-spacing="2">DITUTUP</text>
                        <circle cx="154" cy="66" r="4" fill="#94a3b8"/>
                        <circle cx="186" cy="66" r="4" fill="#94a3b8"/>
                    </g>
                    <g>
                        <rect x="52" y="258" width="26" height="34" rx="13" fill="#64748b"/>
                        <rect x="54" y="288" width="9"  height="18" rx="4" fill="#475569"/>
                        <rect x="65" y="288" width="9"  height="18" rx="4" fill="#475569"/>
                        <ellipse cx="58.5" cy="306" rx="7" ry="5" fill="#1e293b"/>
                        <ellipse cx="69.5" cy="306" rx="7" ry="5" fill="#1e293b"/>
                        <rect x="36" y="260" width="18" height="8" rx="4" fill="#94a3b8" transform="rotate(15,45,264)"/>
                        <rect x="78" y="260" width="18" height="8" rx="4" fill="#94a3b8" transform="rotate(-15,87,264)"/>
                        <rect x="54" y="244" width="8"  height="15" rx="4" fill="#94a3b8"/>
                        <circle cx="58" cy="232" r="18" fill="#cbd5e1"/>
                        <path d="M40 222C40 211 48 205 58 204C68 203 76 211 76 222" fill="#94a3b8"/>
                        <g class="ppdb-sad-eyes">
                            <path d="M51 228 L51 235" stroke="#334155" stroke-width="2.5" stroke-linecap="round"/>
                            <path d="M65 228 L65 235" stroke="#334155" stroke-width="2.5" stroke-linecap="round"/>
                        </g>
                        <path d="M51 242 Q58 237 65 242" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" fill="none"/>
                        <ellipse cx="50" cy="241" rx="2.5" ry="4" fill="#93c5fd" opacity=".8">
                            <animate attributeName="cy"      values="241;258" dur="1.5s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values=".8;0"    dur="1.5s" repeatCount="indefinite"/>
                        </ellipse>
                        <ellipse cx="66" cy="241" rx="2.5" ry="4" fill="#93c5fd" opacity=".8">
                            <animate attributeName="cy"      values="241;258" dur="1.5s" begin=".7s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values=".8;0"    dur="1.5s" begin=".7s" repeatCount="indefinite"/>
                        </ellipse>
                    </g>
                </svg>
            </div>

            <span class="inline-block px-5 py-2 rounded-full bg-slate-200 text-slate-700 text-sm font-semibold tracking-wide">
                PENDAFTARAN DITUTUP
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mt-5 mb-4 px-4 leading-snug">
                Sampai Jumpa di Gelombang Berikutnya
            </h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-lg px-4 mb-10 sm:mb-12">
                Masa pendaftaran periode ini telah resmi berakhir. Terima kasih atas antusiasme Bapak/Ibu kepada SDN 2 Dermolo.
            </p>
            <a href="{{ route('contact') }}" data-spa="/spa/contact"
               class="inline-flex items-center gap-3
                      rounded-full border-2 border-slate-200 bg-white
                      px-8 py-4 sm:px-10 sm:py-5
                      text-base sm:text-lg font-bold text-slate-700
                      shadow-md transition-all duration-200
                      hover:-translate-y-1 hover:shadow-xl hover:border-blue-200 hover:text-blue-700
                      active:scale-95">
                <x-heroicon-o-chat-bubble-left-right class="h-5 w-5 text-blue-500 flex-shrink-0" />
                Hubungi Admin Sekolah
            </a>

        </div>

    {{-- ─────────────────────────────────────────
         STATE 3 : OPEN / CLOSING SOON
    ──────────────────────────────────────────── --}}
    @else
        <div class="ppdb-open-grid items-center">

            {{-- ── Left: CTA ───────────── --}}
            <div class="reveal relative">
                
                {{-- Floating mascot character for Open State (Always visible) --}}
                <div class="absolute -top-32 -left-12 w-40 h-40 opacity-20 pointer-events-none hidden md:block animate-float-kid">
                    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="80" fill="#3b82f6" fill-opacity="0.1" />
                        <rect x="70" y="120" width="60" height="50" rx="25" fill="#3b82f6" />
                        <circle cx="100" cy="85" r="35" fill="#FFD2A8" />
                        <path d="M70 85C70 65 83 50 100 45C117 50 130 65 130 85H70Z" fill="#1E3A8A" />
                        <g class="ppdb-kid-eyes">
                            <circle cx="90" cy="85" r="3" fill="#000" />
                            <circle cx="110" cy="85" r="3" fill="#000" />
                        </g>
                        <path d="M92 100 Q100 106 108 100" stroke="#c47a4a" stroke-width="2" stroke-linecap="round" fill="none"/>
                    </svg>
                </div>

                @if($status === 'closing_soon')
                    <div class="mb-6 sm:mb-8 p-4 sm:p-5 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-start sm:items-center gap-3 text-red-700 shadow-sm animate-pulse">
                        <x-heroicon-o-clock class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0 mt-0.5 sm:mt-0" />
                        <span class="font-bold text-sm sm:text-base leading-snug">Hampir Berakhir! Segera daftarkan ananda.</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-red-600 mb-5 leading-tight tracking-tight">
                        Kesempatan Terakhir!
                    </h2>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-xs font-black tracking-widest mb-6 sm:mb-8 uppercase">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping flex-shrink-0"></span>
                        Pendaftaran Dibuka
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 mb-5 leading-[1.1] tracking-tight">
                        Pendaftaran <span class="text-blue-600">Online Resmi</span>
                    </h2>
                @endif

                <p class="text-base sm:text-lg text-slate-600 mb-8 sm:mb-10 leading-relaxed">
                    Silakan klik tombol di bawah untuk mengisi formulir pendaftaran calon siswa secara online. Proses pendaftaran mudah, cepat, dan transparan.
                </p>

                {{-- ── Daftar Button ─────────── --}}
                <div class="mb-5 sm:mb-6">
                    <a href="{{ route('ppdb.daftar') }}" data-spa="/spa/ppdb/daftar"
                       class="group ppdb-pulse-btn
                              w-full sm:w-auto
                              inline-flex items-center justify-center gap-3
                              rounded-full
                              bg-gradient-to-r from-amber-400 to-orange-500
                              px-10 py-5 sm:px-14 sm:py-5
                              text-lg sm:text-xl font-black text-white
                              shadow-[0_8px_32px_rgba(245,158,11,.45)]
                              transition-all duration-300
                              hover:-translate-y-1
                              hover:shadow-[0_16px_40px_rgba(245,158,11,.55)]
                              active:scale-95">
                        Daftar Sekarang
                        <x-heroicon-o-arrow-right class="w-5 h-5 sm:w-6 sm:h-6 transition-transform group-hover:translate-x-1.5 flex-shrink-0" />
                    </a>
                </div>

                {{-- Deadline info --}}
                <div class="flex items-start gap-2.5 text-slate-400 mb-10 sm:mb-12 pl-1">
                    <x-heroicon-o-calendar class="w-4 h-4 mt-0.5 flex-shrink-0" />
                    <span class="text-sm sm:text-base leading-snug">
                        Batas pendaftaran:
                        <strong class="text-slate-600 font-semibold">{{ $settings->end_date->translatedFormat('d F Y, H:i') }} WIB</strong>
                    </span>
                </div>

                {{-- Feature cards --}}
                <div class="ppdb-feature-grid">
                    <div class="ppdb-feature-card p-4 sm:p-5 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                            <x-heroicon-o-document-check class="w-4 h-4 sm:w-5 sm:h-5" />
                        </div>
                        <div class="font-bold text-slate-800 text-sm leading-snug">Resmi &amp; Terpadu</div>
                        <div class="text-slate-400 text-xs mt-1 leading-relaxed hidden sm:block">Sistem resmi sekolah</div>
                    </div>
                    <div class="ppdb-feature-card p-4 sm:p-5 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                            <x-heroicon-o-bolt class="w-4 h-4 sm:w-5 sm:h-5" />
                        </div>
                        <div class="font-bold text-slate-800 text-sm leading-snug">Tanpa Antri</div>
                        <div class="text-slate-400 text-xs mt-1 leading-relaxed hidden sm:block">Daftar dari rumah</div>
                    </div>
                    <div class="ppdb-feature-card p-4 sm:p-5 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center mb-3">
                            <x-heroicon-o-device-phone-mobile class="w-4 h-4 sm:w-5 sm:h-5" />
                        </div>
                        <div class="font-bold text-slate-800 text-sm leading-snug">Ramah Mobile</div>
                        <div class="text-slate-400 text-xs mt-1 leading-relaxed hidden sm:block">Akses dari HP manapun</div>
                    </div>
                    <div class="ppdb-feature-card p-4 sm:p-5 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-3">
                            <x-heroicon-o-shield-check class="w-4 h-4 sm:w-5 sm:h-5" />
                        </div>
                        <div class="font-bold text-slate-800 text-sm leading-snug">Data Aman</div>
                        <div class="text-slate-400 text-xs mt-1 leading-relaxed hidden sm:block">Privasi terjamin</div>
                    </div>
                </div>

            </div>

            {{-- ── Right: Illustration ──── --}}
            <div class="ppdb-illus-col reveal reveal-delay-2 flex justify-center items-center">
                @if($banners->count() > 0)
                    <div class="relative w-full max-w-sm rounded-[2.5rem] overflow-hidden shadow-2xl border-[12px] border-white bg-white group transition-all duration-500 hover:scale-[1.01]">
                        <div class="aspect-[4/5] w-full bg-slate-100 relative">
                            @foreach($banners as $index => $banner)
                                <div class="absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }} ppdb-banner" data-index="{{ $index }}">
                                    <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover" alt="{{ $banner->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                                    @if($banner->title)
                                        <div class="absolute bottom-0 left-0 right-0 p-8 sm:p-10 bg-gradient-to-t from-black/90 via-black/40 to-transparent text-white">
                                            <div class="font-bold text-xl sm:text-2xl leading-tight">{{ $banner->title }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($banners->count() > 1)
                            <div class="absolute bottom-6 left-0 right-0 flex gap-2.5 z-20 justify-center">
                                @foreach($banners as $index => $banner)
                                    <button class="h-2.5 rounded-full bg-white/40 transition-all duration-300 ppdb-dot {{ $index === 0 ? 'bg-white w-8' : 'w-2.5' }}" data-index="{{ $index }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    {{-- Carnival SVG --}}
                    <div class="w-full" style="max-width:340px">
                        <svg id="ppdb-carnival-svg" viewBox="0 0 340 380" width="100%" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="ppdbSkyG" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%"   stop-color="#bfdbfe"/>
                                    <stop offset="100%" stop-color="#eff6ff"/>
                                </linearGradient>
                            </defs>
                            <rect width="340" height="380" rx="28" fill="url(#ppdbSkyG)"/>
                            <circle cx="56" cy="56" r="24" fill="#fef08a"/>
                            <g class="ppdb-sun-rays" stroke="#fbbf24" stroke-width="3" stroke-linecap="round">
                                <line x1="56" y1="18"  x2="56"  y2="8"/>
                                <line x1="56" y1="104" x2="56"  y2="114"/>
                                <line x1="18" y1="56"  x2="8"   y2="56"/>
                                <line x1="94" y1="56"  x2="104" y2="56"/>
                                <line x1="28" y1="28"  x2="22"  y2="22"/>
                                <line x1="84" y1="84"  x2="90"  y2="90"/>
                                <line x1="28" y1="84"  x2="22"  y2="90"/>
                                <line x1="84" y1="28"  x2="90"  y2="22"/>
                            </g>
                            <circle cx="56" cy="56" r="18" fill="#fde047"/>
                            <g opacity=".88">
                                <ellipse cx="220" cy="58" rx="44" ry="19" fill="#fff"/>
                                <ellipse cx="194" cy="64" rx="24" ry="16" fill="#fff"/>
                                <ellipse cx="248" cy="64" rx="28" ry="15" fill="#fff"/>
                            </g>
                            <g opacity=".70">
                                <ellipse cx="300" cy="100" rx="34" ry="14" fill="#fff"/>
                                <ellipse cx="278" cy="105" rx="20" ry="12" fill="#fff"/>
                                <ellipse cx="318" cy="105" rx="22" ry="12" fill="#fff"/>
                            </g>
                            <rect x="0" y="305" width="340" height="75" fill="#86efac"/>
                            <rect x="0" y="320" width="340" height="60" fill="#4ade80"/>
                            <g stroke="#16a34a" stroke-width="2.5" stroke-linecap="round">
                                @foreach([[18,305],[34,305],[52,305],[70,305],[88,305],[234,305],[252,305],[270,305],[288,305],[306,305],[322,305]] as [$gx,$gy])
                                    <line class="ppdb-grass" x1="{{ $gx }}" y1="{{ $gy }}" x2="{{ $gx-2 }}" y2="{{ $gy-16 }}"/>
                                @endforeach
                            </g>
                            <rect x="96"  y="228" width="148" height="82" rx="4" fill="#e2e8f0"/>
                            <rect x="96"  y="228" width="148" height="22" fill="#94a3b8"/>
                            <polygon points="84,232 170,178 256,232" fill="#cbd5e1"/>
                            <polygon points="84,232 170,178 256,232" fill="none" stroke="#94a3b8" stroke-width="2"/>
                            <rect x="110" y="244" width="32" height="24" rx="4" fill="#bfdbfe"/>
                            <line x1="126" y1="244" x2="126" y2="268" stroke="#93c5fd" stroke-width="1.5"/>
                            <line x1="110" y1="256" x2="142" y2="256" stroke="#93c5fd" stroke-width="1.5"/>
                            <rect x="198" y="244" width="32" height="24" rx="4" fill="#bfdbfe"/>
                            <line x1="214" y1="244" x2="214" y2="268" stroke="#93c5fd" stroke-width="1.5"/>
                            <line x1="198" y1="256" x2="230" y2="256" stroke="#93c5fd" stroke-width="1.5"/>
                            <rect x="152" y="268" width="36" height="42" rx="5" fill="#60a5fa"/>
                            <circle cx="163" cy="291" r="3" fill="#1d4ed8"/>
                            <line x1="170" y1="178" x2="170" y2="144" stroke="#64748b" stroke-width="2.5"/>
                            <rect x="170" y="144" width="26" height="18" rx="2" fill="#ef4444"/>
                            <path d="M128 278 Q158 234 195 210 Q210 200 224 193" stroke="#94a3b8" stroke-width="1.5" fill="none" stroke-dasharray="4 3"/>
                            <g class="ppdb-kite" style="transform-origin:224px 193px">
                                <polygon points="224,163 252,193 224,223 196,193" fill="#f59e0b"/>
                                <polygon points="224,163 252,193 224,193" fill="#d97706" opacity=".6"/>
                                <line x1="196" y1="193" x2="252" y2="193" stroke="#92400e" stroke-width="1"/>
                                <line x1="224" y1="163" x2="224" y2="223" stroke="#92400e" stroke-width="1"/>
                                <path fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" d="M224,223 Q231,237 219,251 Q211,263 224,275">
                                    <animate attributeName="d" values="M224,223 Q231,237 219,251 Q211,263 224,275;M224,223 Q241,236 233,251 Q227,265 239,275;M224,223 Q231,237 219,251 Q211,263 224,275" dur="2s" repeatCount="indefinite"/>
                                </path>
                                <circle cx="224" cy="193" r="4" fill="#fff" opacity=".6"/>
                            </g>
                            <g class="ppdb-b1 ppdb-balloon" onclick="ppdbPopBalloon(this,'#ef4444')">
                                <ellipse cx="48"  cy="155" rx="20" ry="26" fill="#ef4444"/>
                                <ellipse cx="42"  cy="146" rx="6"  ry="7"  fill="#f87171" opacity=".6"/>
                                <path d="M48 181 Q46 192 50 203" stroke="#9ca3af" stroke-width="1.5" fill="none"/>
                                <circle cx="50" cy="205" r="2.5" fill="#9ca3af"/>
                            </g>
                            <g class="ppdb-b2 ppdb-balloon" onclick="ppdbPopBalloon(this,'#8b5cf6')">
                                <ellipse cx="104" cy="140" rx="18" ry="23" fill="#8b5cf6"/>
                                <ellipse cx="97"  cy="132" rx="5"  ry="6"  fill="#a78bfa" opacity=".6"/>
                                <path d="M104 163 Q102 173 106 183" stroke="#9ca3af" stroke-width="1.5" fill="none"/>
                                <circle cx="106" cy="185" r="2.5" fill="#9ca3af"/>
                            </g>
                            <g class="ppdb-b3 ppdb-balloon" onclick="ppdbPopBalloon(this,'#10b981')">
                                <ellipse cx="40"  cy="205" rx="17" ry="22" fill="#10b981"/>
                                <ellipse cx="34"  cy="197" rx="4.5" ry="5.5" fill="#34d399" opacity=".6"/>
                                <path d="M40 227 Q38 237 42 247" stroke="#9ca3af" stroke-width="1.5" fill="none"/>
                                <circle cx="42" cy="249" r="2.5" fill="#9ca3af"/>
                            </g>
                            <g class="ppdb-b4 ppdb-balloon" onclick="ppdbPopBalloon(this,'#3b82f6')">
                                <ellipse cx="158" cy="125" rx="19" ry="25" fill="#3b82f6"/>
                                <ellipse cx="151" cy="115" rx="5.5" ry="7"  fill="#60a5fa" opacity=".6"/>
                                <path d="M158 150 Q156 161 160 172" stroke="#9ca3af" stroke-width="1.5" fill="none"/>
                                <circle cx="160" cy="174" r="2.5" fill="#9ca3af"/>
                            </g>
                            <g>
                                <rect x="248" y="268" width="26" height="38" rx="13" fill="#3b82f6"/>
                                <rect x="250" y="302" width="9"  height="22" rx="4" fill="#1d4ed8"/>
                                <rect x="263" y="302" width="9"  height="22" rx="4" fill="#1d4ed8"/>
                                <ellipse cx="254.5" cy="324" rx="8"   ry="5.5" fill="#0f172a"/>
                                <ellipse cx="267.5" cy="324" rx="8"   ry="5.5" fill="#0f172a"/>
                                <rect x="233" y="270" width="18" height="9" rx="4.5" fill="#fcd5ae" transform="rotate(12,242,274)"/>
                                <g class="ppdb-arm-wave">
                                    <rect x="272" y="263" width="20" height="9" rx="4.5" fill="#fcd5ae" transform="rotate(-36,272,267)"/>
                                </g>
                                <rect x="256" y="253" width="8"  height="17" rx="4" fill="#fcd5ae"/>
                                <circle cx="260" cy="241" r="20" fill="#fcd5ae"/>
                                <path d="M240 231C240 219 248 212 260 211C272 210 280 219 280 231" fill="#7c3aed"/>
                                <ellipse cx="260" cy="211" rx="13" ry="7" fill="#7c3aed"/>
                                <circle cx="254" cy="240" r="3.5" fill="#0f172a"/>
                                <circle cx="266" cy="240" r="3.5" fill="#0f172a"/>
                                <circle cx="255" cy="239" r="1.2" fill="#fff"/>
                                <circle cx="267" cy="239" r="1.2" fill="#fff"/>
                                <path d="M253 248 Q260 253 267 248" stroke="#c47a4a" stroke-width="2" stroke-linecap="round" fill="none"/>
                                <circle cx="249" cy="245" r="4.5" fill="#fca5a5" opacity=".5"/>
                                <circle cx="271" cy="245" r="4.5" fill="#fca5a5" opacity=".5"/>
                            </g>
                            <g id="ppdb-confetti-layer"></g>
                        </svg>
                        <p class="text-center text-xs text-slate-400 font-semibold mt-3">🎈 Ketuk balon untuk memecahkan!</p>
                    </div>
                @endif
            </div>

        </div>
    @endif

    </div>
    </section>

    {{-- ═══════════════════════════════════════════
    BANNER & POSTER SECTION
    ══════════════════════════════════════════════ --}}
    @if($banners->count() > 0)
    <section class="py-20 px-6 bg-white border-t border-slate-100">
    <div class="max-w-[1200px] mx-auto">
    <div class="text-center mb-16 reveal">
        <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-black tracking-[0.2em] uppercase">Informasi Visual</span>
        <h2 class="text-3xl md:text-4xl font-black text-slate-900 mt-4 tracking-tight">Poster & Pengumuman</h2>
        <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Informasi lengkap mengenai alur, persyaratan, dan jadwal PPDB SDN 2 Dermolo dalam bentuk poster resmi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        @foreach($banners as $index => $banner)
            <div class="reveal reveal-delay-{{ ($index % 3) + 1 }} group">
                <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-[12px] border-white bg-slate-50 transition-all duration-500 hover:scale-[1.02] hover:shadow-blue-200/50">
                    <img src="{{ asset('storage/' . $banner->image_path) }}" 
                         class="w-full h-auto object-cover" 
                         alt="{{ $banner->title ?? 'Poster PPDB' }}"
                         loading="lazy">

                    @if($banner->title)
                        <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/80 via-black/20 to-transparent text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <h3 class="font-bold text-xl">{{ $banner->title }}</h3>
                        </div>
                    @endif

                    {{-- Zoom Icon Overlay --}}
                    <div class="absolute inset-0 bg-blue-600/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="w-16 h-16 rounded-full bg-white text-blue-600 flex items-center justify-center shadow-xl transform scale-50 group-hover:scale-100 transition-transform duration-500">
                            <x-heroicon-o-magnifying-glass-plus class="w-8 h-8" />
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>
    </section>
    @endif

    <script>

/* ── Countdown Timer ─────────────────────────── */
(function(){
    const el = document.getElementById('ppdb-countdown');
    if(!el) return;
    const untilStr = el.dataset.until;
    if(!untilStr) return;
    const until = new Date(untilStr).getTime();
    const ids = { d:'cd-d', h:'cd-h', m:'cd-m', s:'cd-s' };
    function pad(n){ return String(n).padStart(2,'0'); }
    function tick(){
        const now = Date.now();
        const diff = until - now;
        if(diff <= 0){
            for(const k in ids) {
                const e = document.getElementById(ids[k]);
                if(e) e.textContent = '00';
            }
            // Auto refresh when countdown ends to update page state
            clearInterval(timer);
            setTimeout(() => {
                if (window.loadSPAContent) {
                    window.loadSPAContent('/spa/ppdb', 'PPDB Online - SD N 2 Dermolo', true);
                } else {
                    window.location.reload();
                }
            }, 1000);
            return;
        }
        const d = Math.floor(diff/86400000),
              h = Math.floor((diff%86400000)/3600000),
              m = Math.floor((diff%3600000)/60000),
              s = Math.floor((diff%60000)/1000);
        const box = { d, h, m, s };
        for(const k in ids){
            const e = document.getElementById(ids[k]);
            if(e) e.textContent = pad(box[k]);
        }
    }
    tick();
    const timer = setInterval(tick, 1000);
})();

/* ── Balloon Pop ─────────────────────────────── */
window.ppdbPopBalloon = function(el, color){
    const layer = document.getElementById('ppdb-confetti-layer');
    if(!layer || el.dataset.popped) return;
    el.dataset.popped = '1';
    const ell = el.querySelector('ellipse');
    const cx  = parseFloat(ell.getAttribute('cx'));
    const cy  = parseFloat(ell.getAttribute('cy'));
    el.style.transition = 'opacity .12s';
    el.style.opacity = '0';
    setTimeout(()=>{ el.style.display='none'; }, 130);
    const palette = ['#ef4444','#f59e0b','#10b981','#3b82f6','#8b5cf6','#ec4899','#f97316','#fde047'];
    const NS = 'http://www.w3.org/2000/svg';
    for(let i=0;i<16;i++){
        const ang  = (i/16)*Math.PI*2;
        const dist = 24 + Math.random()*42;
        const r    = document.createElementNS(NS,'rect');
        r.setAttribute('x', cx-4); r.setAttribute('y', cy-4);
        r.setAttribute('width','8'); r.setAttribute('height','8'); r.setAttribute('rx','2');
        r.setAttribute('fill', palette[Math.floor(Math.random()*palette.length)]);
        r.style.cssText = `--cx:${Math.cos(ang)*dist}px;--cy:${Math.sin(ang)*dist}px;animation:confetti-burst .85s ease-out forwards`;
        layer.appendChild(r);
        setTimeout(()=>r.remove(), 920);
    }
    const txt = document.createElementNS(NS,'text');
    txt.setAttribute('x', cx); txt.setAttribute('y', cy+6);
    txt.setAttribute('text-anchor','middle');
    txt.setAttribute('font-family','sans-serif');
    txt.setAttribute('font-size','20');
    txt.setAttribute('font-weight','900');
    txt.setAttribute('fill', color);
    txt.textContent = 'POP!';
    txt.style.cssText = '--cx:0px;--cy:-32px;animation:confetti-burst .65s ease-out forwards';
    layer.appendChild(txt);
    setTimeout(()=>txt.remove(), 700);
};

/* ── Banner Carousel ─────────────────────────── */
(function(){
    const banners = document.querySelectorAll('.ppdb-banner');
    const dots    = document.querySelectorAll('.ppdb-dot');
    if(banners.length <= 1) return;
    let cur = 0;
    function go(idx){
        if(!banners[cur] || !banners[idx]) return;
        banners[cur].classList.replace('opacity-100','opacity-0');
        if(dots[cur]) {
            dots[cur].classList.remove('bg-white','w-8'); 
            dots[cur].classList.add('w-2.5');
        }
        cur = idx;
        banners[cur].classList.replace('opacity-0','opacity-100');
        if(dots[cur]) {
            dots[cur].classList.remove('w-2.5'); 
            dots[cur].classList.add('bg-white','w-8');
        }
    }
    dots.forEach((d,i)=>d.addEventListener('click',()=>go(i)));
    const timer = setInterval(()=>go((cur+1)%banners.length), 4500);
})();

/* ── Hero Background Loop ────────────────────── */
(function(){
    const bgs = document.querySelectorAll('.ppdb-hero-bg');
    if(bgs.length <= 1) return;
    let cur = 0;
    setInterval(() => {
        bgs[cur].classList.replace('opacity-100', 'opacity-0');
        cur = (cur + 1) % bgs.length;
        bgs[cur].classList.replace('opacity-0', 'opacity-100');
    }, 6000);
})();
</script>
