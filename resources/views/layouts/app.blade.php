<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SD N 2 Dermolo')</title>
    @if (trim($__env->yieldContent('meta_description')))
        <meta name="description" content="@yield('meta_description')">
    @endif
    @php
        $schoolProfile = \App\Models\SchoolProfile::getOrCreate();
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/modals.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, input, textarea, select {
            font-family: "Roboto", system-ui, sans-serif;
        }
        .font-body {
            font-family: "Roboto", system-ui, sans-serif;
        }
        h1, h2, h3, h4, h5, h6,
        button,
        nav,
        summary,
        .font-display,
        .section-label,
        .hero-badge {
            font-family: "Poppins", system-ui, sans-serif;
        }
        /* Custom animations - used by utility classes below */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-20px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* Animation utility classes */
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-bounce { animation: bounce 2s infinite; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-fadeIn { animation: fadeIn 0.6s ease-in; }
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: none;
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }
        /* Card hover effects */
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .teacher-card { transition: all 0.3s ease; }
        .teacher-card:hover { transform: scale(1.05); }
        .hero-fullscreen {
            min-height: 100vh;
            padding-top: 76px;
        }
        .hero-fullscreen .hero-content {
            min-height: calc(100vh - 76px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .hero-slide-media {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .tentang-visual-main {
            height: 100%;
            width: 100%;
            min-height: 350px;
        }
        @media (min-width: 768px) {
            .tentang-grid > div:first-child .tentang-visual-main {
                min-height: 420px;
            }
        }
        /* ===== FOOTER NAVIGATION STYLES ===== */
        /* Remove all focus/click effects on footer navigation links */
        .footer-nav a:focus,
        .footer-nav a:active,
        .footer-nav a:focus-visible,
        .footer-nav a:visited {
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
            -webkit-tap-highlight-color: transparent;
        }

        .footer-nav li a:focus,
        .footer-nav li a:active,
        .footer-nav li a:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            -webkit-tap-highlight-color: transparent;
        }

        /* Remove focus effects on footer social media icons */
        .footer-social a:focus,
        .footer-social a:active,
        .footer-social a:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            -webkit-tap-highlight-color: transparent;
        }

        /* Remove focus effects on footer Google Maps link */
        .footer-maps a:focus,
        .footer-maps a:active,
        .footer-maps a:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            background: transparent !important;
            -webkit-tap-highlight-color: transparent;
        }

        /* Remove any default focus ring in footer */
        footer *:focus,
        footer *:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            -webkit-tap-highlight-color: transparent;
        }

        /* Remove focus outline on all SPA navigation links in footer */
        footer a[data-spa]:focus,
        footer a[data-spa]:focus-visible,
        footer a[data-spa]:active {
            outline: none !important;
            box-shadow: none !important;
            -webkit-tap-highlight-color: transparent;
        }

        /* Smooth hover animation for footer navigation links */
        .footer-nav a {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-nav a::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%) translateX(-4px);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            border-radius: 1px;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-nav a:hover {
            color: #ffffff !important;
            transform: translateX(6px);
        }

        .footer-nav a:hover::before {
            width: 12px;
            opacity: 1;
            left: -8px;
        }

        /* Smooth hover animation for footer contact links */
        .footer-contact a {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-contact a:hover {
            color: #ffffff !important;
        }

        /* Smooth hover animation for footer social icons */
        .footer-social a {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-social a:hover {
            transform: scale(1.15) translateY(-2px);
        }

        /* ===== FOOTER ACTIVE LINK STYLES ===== */
        /* Active state for footer navigation links - NO background highlight */
        footer .spa-nav-link {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Ensure active footer links don't get unwanted background */
        footer .spa-nav-link.text-white {
            background: transparent !important;
            background-color: transparent !important;
        }

        /* Add subtle underline indicator for active footer link */
        footer .spa-nav-link.text-white::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
            border-radius: 1px;
        }

        /* Ensure footer links don't inherit any unwanted styles */
        footer .footer-nav a {
            background: transparent !important;
        }

        /* ===== ABOUT PAGE ANIMATIONS ===== */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(0) translateX(20px);
            }
            75% {
                transform: translateY(20px) translateX(10px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* 
         * PUBLIC MODAL CONFIRMATION BUTTON FIX
         * Fix untuk tombol 'Lanjutkan' di modal konfirmasi public
         */
        #public-confirm-ok {
            background-color: #DC2626 !important;       /* Merah gelap */
            color: #FFFFFF !important;                   /* Teks putih */
            border: 2px solid #DC2626 !important;        /* Border merah */
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        #public-confirm-ok:hover {
            background-color: #B91C1C !important;
            border-color: #B91C1C !important;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4) !important;
            transform: translateY(-1px);
        }

        #public-confirm-cancel {
            background-color: #FFFFFF !important;
            color: #475569 !important;
            border: 2px solid #CBD5E1 !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        #public-confirm-cancel:hover {
            background-color: #F1F5F9 !important;
            border-color: #94A3B8 !important;
        }

        /* Force all modal buttons to be visible */
        #public-confirm-modal button[type="button"] {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
    @stack('styles')
</head>
<body class="scroll-smooth bg-gray-50">

    {{-- ===== NAVBAR ===== --}}
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-gradient-to-b from-slate-50 to-white shadow-[0_10px_30px_rgba(15,23,42,0.08)]">
        <div class="mx-auto grid h-[76px] max-w-6xl grid-cols-[auto,1fr,auto] items-center gap-6 px-4 lg:px-14">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3.5">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    @if($schoolProfile->logo)
                        <img src="{{ asset('storage/' . $schoolProfile->logo) }}" alt="{{ $schoolProfile->school_name }}" class="w-full h-full object-contain p-1">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-sm font-extrabold text-white">
                            SD
                        </div>
                    @endif
                </div>
                <div class="mr-8">
                    <h1 class="text-base font-extrabold leading-tight text-slate-900">SD N 2 Dermolo</h1>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Unggul & Berkarakter</p>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center justify-center gap-5 font-semibold text-slate-500 md:ml-8">
                <a href="{{ route('home') }}#home" data-spa="/spa/home" data-spa-title="Beranda - SD N 2 Dermolo" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('home') && !request()->filled('section') ? 'bg-emerald-50 text-blue-600' : '' }}">Beranda</a>

                {{-- Dropdown Profil dengan Pure CSS --}}
                <div class="relative group">
                    <button class="inline-flex items-center gap-1 rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ (request()->routeIs('fasilitas.*') || request()->routeIs('program.*')) ? 'bg-emerald-50 text-blue-600' : '' }}" type="button">
                        Profil
                        <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    {{-- Dropdown Menu --}}
                    <div class="absolute left-1/2 top-full mt-0 w-56 -translate-x-1/2 rounded-xl bg-white p-2 text-slate-900 shadow-[0_16px_40px_rgba(15,23,42,0.12)] border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 translate-y-2 group-hover:translate-y-0">
                        <a href="{{ route('about') }}" data-spa="/spa/about" data-spa-title="Tentang Kami - SD N 2 Dermolo" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : '' }}">Identitas Sekolah</a>
                        <a href="{{ route('fasilitas.index') }}" data-spa="/spa/sarana-prasarana" data-spa-title="Sarana Prasarana - SD N 2 Dermolo" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('fasilitas.*') ? 'bg-blue-50 text-blue-600' : '' }}">Sarana Prasarana</a>
                        <a href="{{ route('program.index') }}" data-spa="/spa/program" data-spa-title="Program - SD N 2 Dermolo" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('program.*') ? 'bg-blue-50 text-blue-600' : '' }}">Ekstrakurikuler</a>
                    </div>
                </div>

                <a href="{{ route('guru.index') }}" data-spa="/spa/data-guru" data-spa-title="Data Guru - SD N 2 Dermolo" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('guru.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Data Guru</a>
                <a href="{{ route('news.index') }}" data-spa="/spa/berita" data-spa-title="Berita - SD N 2 Dermolo" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('news.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Berita</a>
                <a href="{{ route('prestasi.index') }}" data-spa="/spa/prestasi" data-spa-title="Prestasi - SD N 2 Dermolo" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('prestasi.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Prestasi</a>
                <a href="{{ route('gallery.index') }}" data-spa="/spa/gallery" data-spa-title="Galeri - SD N 2 Dermolo" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('gallery.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Galeri</a>
                <a href="{{ route('home') }}#kontak" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600">Kontak</a>
            </div>

            {{-- Right Side Actions - Removed for cleaner navigation --}}

            {{-- Tombol Hamburger (Mobile) --}}
            <button id="mobile-menu-button" class="md:hidden rounded-md p-2 text-slate-600 hover:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Menu Mobile --}}
        <div id="mobile-menu" class="hidden md:hidden space-y-3 border-t border-slate-200 bg-white px-4 pb-4 pt-3">
            <a href="{{ route('home') }}#home" data-spa="/spa/home" data-spa-title="Beranda - SD N 2 Dermolo" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">Beranda</a>
            <details class="rounded-xl bg-slate-50 px-3 py-2">
                <summary class="cursor-pointer font-semibold text-slate-600">Profil</summary>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('about') }}" data-spa="/spa/about" data-spa-title="Tentang Kami - SD N 2 Dermolo" class="block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500">Identitas Sekolah</a>
                    <a href="{{ route('fasilitas.index') }}" data-spa="/spa/sarana-prasarana" data-spa-title="Sarana & Prasarana - SD N 2 Dermolo" class="block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500">Sarana Prasarana</a>
                    <a href="{{ route('program.index') }}" data-spa="/spa/program" data-spa-title="Program - SD N 2 Dermolo" class="block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500">Ekstrakurikuler</a>
                </div>
            </details>
            <a href="{{ route('guru.index') }}" data-spa="/spa/data-guru" data-spa-title="Data Guru - SD N 2 Dermolo" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('guru.*') ? 'text-blue-600' : '' }}">Data Guru</a>
            <a href="{{ route('news.index') }}" data-spa="/spa/berita" data-spa-title="Berita - SD N 2 Dermolo" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('news.*') ? 'text-blue-600' : '' }}">Berita</a>
            <a href="{{ route('prestasi.index') }}" data-spa="/spa/prestasi" data-spa-title="Prestasi - SD N 2 Dermolo" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('prestasi.*') ? 'text-blue-600' : '' }}">Prestasi</a>
            <a href="{{ route('gallery.index') }}" data-spa="/spa/gallery" data-spa-title="Galeri - SD N 2 Dermolo" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('gallery.*') ? 'text-blue-600' : '' }}">Galeri</a>
            <a href="{{ route('home') }}#kontak" class="block py-2 font-semibold text-slate-600">Kontak</a>
            
            {{-- Mobile Admin Actions --}}
            @auth
                <div class="pt-3 border-t border-slate-200">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block w-full py-3 px-4 rounded-xl bg-slate-900 text-white text-sm font-semibold text-center mb-2">
                        <x-heroicon-o-cog-6-tooth class="w-4 h-4 inline mr-2" />
                        Dashboard Admin
                    </a>
                    <form action="{{ route('logout') }}" method="POST" data-confirm="Yakin ingin logout?">
                        @csrf
                        <button type="submit" class="block w-full py-2 px-4 rounded-xl border border-red-300 text-red-600 text-sm font-semibold text-center hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    {{-- ===== KONTEN HALAMAN ===== --}}
    <main id="main-content" style="opacity: 1; visibility: visible; min-height: 400px;">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-gradient-to-b from-slate-900 to-blue-950 text-white py-14 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

                {{-- Kolom 1: Tentang Sekolah --}}
                <div>
                    <div class="flex items-center mb-5">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-md mr-3 overflow-hidden">
                            @if($schoolProfile->logo)
                                <img src="{{ asset('storage/' . $schoolProfile->logo) }}" alt="{{ $schoolProfile->school_name }}" class="w-full h-full object-contain p-1">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-white font-bold text-lg">
                                    SD
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ $schoolProfile->school_name ?? 'SD N 2 Dermolo' }}</h3>
                            <p class="text-blue-300 text-xs">Jepara, Jawa Tengah</p>
                        </div>
                    </div>
                    <p class="text-blue-200/80 text-sm leading-relaxed mb-5">
                        Sekolah berkomitmen memberikan pendidikan berkualitas tinggi bagi generasi muda Indonesia dengan mengutamakan kecerdasan dan karakter.
                    </p>

                    {{-- Social Media Icons --}}
                    <div class="footer-social flex items-center gap-3">
                        <a href="https://wa.me/6289668982633"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center"
                           aria-label="WhatsApp">
                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                        <a href="https://youtube.com/@sdnegeri2dermolo?feature=shared"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-9 h-9 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center"
                           aria-label="YouTube">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Kolom 2: Navigasi --}}
                <div class="footer-nav">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-blue-300 mb-4">NAVIGASI</h4>
                    <ul class="space-y-2.5 text-blue-200/80 text-sm">
                        <li><a href="{{ route('home') }}" data-spa="/spa/home" data-spa-title="Beranda - SD N 2 Dermolo" class="spa-nav-link inline-block">Beranda</a></li>
                        <li><a href="{{ route('about') }}" data-spa="/spa/about" data-spa-title="Profil - SD N 2 Dermolo" class="spa-nav-link inline-block">Profil</a></li>
                        <li><a href="{{ route('guru.index') }}" data-spa="/spa/data-guru" data-spa-title="Tenaga Kependidikan - SD N 2 Dermolo" class="spa-nav-link inline-block">Tenaga Kependidikan</a></li>
                        <li><a href="{{ route('prestasi.index') }}" data-spa="/spa/prestasi" data-spa-title="Prestasi - SD N 2 Dermolo" class="spa-nav-link inline-block">Prestasi</a></li>
                        <li><a href="{{ route('gallery.index') }}" data-spa="/spa/gallery" data-spa-title="Galeri - SD N 2 Dermolo" class="spa-nav-link inline-block">Galeri</a></li>
                        <li><a href="{{ route('fasilitas.index') }}" data-spa="/spa/sarana-prasarana" data-spa-title="Fasilitas - SD N 2 Dermolo" class="spa-nav-link inline-block">Fasilitas</a></li>
                        <li><a href="{{ route('home') }}#kontak" data-spa="/spa/home" data-spa-title="Kontak - SD N 2 Dermolo" data-spa-hash="#kontak" class="spa-nav-link inline-block">Kontak</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Kontak Kami --}}
                <div class="footer-contact">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-blue-300 mb-4">KONTAK KAMI</h4>
                    <ul class="space-y-3 text-blue-200/80 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-pink-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <span>Desa Dermolo RT. 03 RW. 01, Kecamatan Kembang, Kabupaten Jepara, Provinsi Jawa Tengah</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-pink-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            <span>0896-6898-2633</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span>sdndermolo728@gmail.com</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-300 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                            <span>Senin - Jumat: 07.00 - 14.00 WIB<br>Sabtu: 07.00 - 13.00 WIB</span>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 4: Lokasi (Google Maps) --}}
                <div class="footer-maps">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-blue-300 mb-4">LOKASI</h4>
                    <a href="https://maps.google.com/?q=SD+Negeri+2+Dermolo,+Kembang,+Jepara"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block rounded-xl overflow-hidden shadow-lg border-2 border-white/10 h-full min-h-[240px] max-h-[260px] cursor-pointer hover:shadow-2xl hover:border-white/20 transition-all duration-300 group"
                       aria-label="Buka Google Maps - SD N 2 Dermolo">
                        <div class="relative w-full h-full min-h-[240px]">
                            <iframe
                                src="https://maps.google.com/maps?q=SD+Negeri+2+Dermolo,+Kembang,+Jepara&output=embed"
                                width="100%"
                                height="100%"
                                style="border:0; pointer-events: none;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full h-full min-h-[240px]">
                            </iframe>
                            {{-- Overlay hint --}}
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-300 flex items-center justify-center">
                                <div class="bg-white/90 group-hover:bg-white px-3 py-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                    <span class="text-xs font-semibold text-slate-700 flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Buka Maps
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            {{-- Copyright Section --}}
            <div class="border-t border-white/10 pt-8 text-center">
                <p class="text-blue-200/70 text-sm">
                    © {{ date('Y') }} SD N 2 Dermolo. Hak cipta dilindungi. Dikembangkan oleh Dani Pramudianto.
                </p>
            </div>
        </div>
    </footer>

    <div id="public-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" data-confirm-close="true"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mx-auto mb-4">
                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 text-center">Konfirmasi</h3>
            <p id="public-confirm-message" class="mt-2 text-sm text-slate-600 text-center">Apakah Anda yakin?</p>
            <div class="mt-6 flex items-center justify-center gap-4">
                <button type="button" 
                        id="public-confirm-cancel"
                        class="px-8 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                    Batal
                </button>
                <button type="button" 
                        id="public-confirm-ok"
                        class="px-8 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    {{-- ===== TOMBOL SCROLL TO TOP ===== --}}
    <button id="scrollToTop"
        class="fixed bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition duration-300 transform hover:scale-110 hidden z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    {{-- ===== JAVASCRIPT ===== --}}
    {{-- Global UI JavaScript for common components --}}
    <script src="{{ asset('js/global-ui.js') }}"></script>

    {{-- SPA JavaScript for dynamic content loading --}}
    <script src="{{ asset('js/spa.js') }}"></script>

    {{-- Footer Navigation Enhancement Script --}}
    <script>
        // Ensure footer SPA links work correctly
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handlers to all footer SPA links
            const footerSpaLinks = document.querySelectorAll('footer a[data-spa]');

            footerSpaLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const route = this.dataset.spa;
                    const title = this.dataset.spaTitle || document.title;
                    const hash = this.dataset.spaHash || this.hash || '';

                    // Trigger SPA navigation if spa.js is loaded
                    if (typeof window.loadContent === 'function') {
                        window.loadContent(route, title, true, hash);
                    } else {
                        // Fallback: navigate directly to the URL
                        const url = new URL(this.href, window.location.origin);
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
