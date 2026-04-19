<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin SD N 2 Dermolo')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        border: "hsl(214.3 31.8% 91.4%)",
                        input: "hsl(214.3 31.8% 91.4%)",
                        ring: "hsl(215 20.2% 65.1%)",
                        background: "hsl(0 0% 100%)",
                        foreground: "hsl(222.2 84% 4.9%)",
                        primary: {
                            DEFAULT: "hsl(222.2 47.4% 11.2%)",
                            foreground: "hsl(210 40% 98%)",
                        },
                        secondary: {
                            DEFAULT: "hsl(210 40% 96.1%)",
                            foreground: "hsl(222.2 47.4% 11.2%)",
                        },
                        muted: {
                            DEFAULT: "hsl(210 40% 96.1%)",
                            foreground: "hsl(215.4 16.3% 46.9%)",
                        },
                        accent: {
                            DEFAULT: "hsl(210 40% 96.1%)",
                            foreground: "hsl(222.2 47.4% 11.2%)",
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Modern Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 20px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }

        body {
            background-color: #F8FAFC;
            color: #0F172A;
            -webkit-font-smoothing: antialiased;
        }

        /* Sidebar Transition Logic */
        .sidebar-transition {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-expanded { width: 280px; }
        .sidebar-collapsed { width: 80px; }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.625rem 0.85rem;
            border-radius: 0.5rem;
            color: #94A3B8;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #F8FAFC;
        }

        .nav-item.is-active {
            background: #0EA5E9;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
        }

        .nav-item.is-active svg {
            color: #FFFFFF !important;
        }

        .nav-text {
            transition: opacity 0.2s ease, transform 0.2s ease;
            margin-left: 0.85rem;
        }

        .sidebar-collapsed .nav-text,
        .sidebar-collapsed .sidebar-label,
        .sidebar-collapsed .sidebar-header-text,
        .sidebar-collapsed .sidebar-footer-text {
            opacity: 0;
            pointer-events: none;
            width: 0;
            margin-left: 0;
        }

        .sidebar-collapsed .sidebar-header-container {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        /* Mobile Drawer State */
        .mobile-sidebar-open { transform: translateX(0); }
        .mobile-sidebar-closed { transform: translateX(-100%); }

        /* Glass Cards */
        .glass-card {
            background: white;
            border: 1px solid #E2E8F0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            border-radius: 0.75rem;
        }

        /* Submenu Style */
        .sidebar-sub-item {
            padding: 0.5rem 0.75rem 0.5rem 2.85rem;
            color: #64748B;
            font-size: 0.85rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .sidebar-collapsed .sidebar-sub-item { display: none; }
        
        .sidebar-sub-item:hover { color: white; background: rgba(255,255,255,0.03); }
        .sidebar-sub-item.is-active { color: #38BDF8; font-weight: 600; }

        @media (max-width: 1024px) {
            .main-content-shift { margin-left: 0 !important; }
        }

        /* Confirm Modal Button Styling to match Shadcn */
        #confirm-ok {
            background-color: #DC2626 !important;
            color: #FFFFFF !important;
            border-radius: 0.5rem !important;
        }

        #confirm-cancel {
            background-color: #F8FAFC !important;
            color: #475569 !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 0.5rem !important;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">
    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-[40] hidden backdrop-blur-sm lg:hidden transition-opacity"></div>

    {{-- Main Container --}}
    <div class="flex h-screen overflow-hidden">
        
        {{-- SIDEBAR --}}
        <aside id="sidebar" 
               class="sidebar-transition fixed inset-y-0 left-0 z-[50] flex flex-col bg-slate-950 border-r border-slate-800 lg:static sidebar-expanded mobile-sidebar-closed lg:translate-x-0">
            
            {{-- Sidebar Header --}}
            <div class="h-20 flex-shrink-0 flex items-center px-6 border-b border-slate-800/50 sidebar-header-container overflow-hidden">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center group">
                    @php $schoolProfile = \App\Models\SchoolProfile::getOrCreate(); @endphp
                    <div class="w-10 h-10 rounded-xl bg-white shadow-lg flex items-center justify-center p-1 flex-shrink-0">
                        <img src="{{ $schoolProfile->logo ? asset('storage/' . $schoolProfile->logo) : asset('storage/school-profile/logo_default.png') }}" 
                             onerror="this.src='{{ asset('logosdreal.png') }}'; this.onerror=null;"
                             class="w-full h-full object-contain" alt="Logo">
                    </div>
                    <div class="sidebar-header-text ml-3 overflow-hidden transition-all duration-300">
                        <p class="text-sm font-extrabold text-white leading-tight tracking-tight whitespace-nowrap">Admin SD N 2</p>
                        <p class="text-[0.6rem] text-cyan-500 font-bold tracking-[0.1em] uppercase">Dermolo - Jepara</p>
                    </div>
                </a>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-6 custom-scrollbar">
                
                {{-- Group 1: CORE --}}
                <div class="space-y-1">
                    <p class="sidebar-label px-2 mb-2 text-[0.65rem] font-bold text-slate-500 tracking-[0.15em] uppercase transition-opacity">NAVIGASI</p>
                    
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" title="Dashboard">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="nav-text">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.school-profile.edit') }}" class="nav-item {{ request()->routeIs('admin.school-profile.*') ? 'is-active' : '' }}" title="Profil Sekolah">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="nav-text">Profil Sekolah</span>
                    </a>

                    <a href="{{ route('admin.hidden-settings') }}" class="nav-item {{ request()->routeIs('admin.hidden-settings') ? 'is-active' : '' }}" title="Sambutan & Foto">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span class="nav-text">Sambutan Kepsek</span>
                    </a>

                    <a href="{{ route('admin.hero-slides.index') }}" class="nav-item {{ request()->routeIs('admin.hero-slides.*') ? 'is-active' : '' }}" title="Slideshow">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="nav-text">Slideshow Beranda</span>
                    </a>
                </div>

                {{-- Group 2: ACADEMIC --}}
                <div class="space-y-1">
                    <p class="sidebar-label px-2 mb-2 text-[0.65rem] font-bold text-slate-500 tracking-[0.15em] uppercase transition-opacity">AKADEMIK</p>
                    
                    <a href="{{ route('admin.ppdb.index') }}" class="nav-item {{ request()->routeIs('admin.ppdb.*') ? 'is-active' : '' }}" title="PPDB">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span class="nav-text">Manajemen PPDB</span>
                    </a>

                    <a href="{{ route('admin.program-sekolah.index') }}" class="nav-item {{ request()->routeIs('admin.program-sekolah.*') ? 'is-active' : '' }}" title="Program">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span class="nav-text">Program Sekolah</span>
                    </a>

                    <a href="{{ route('admin.prestasi-sekolah.index') }}" class="nav-item {{ request()->routeIs('admin.prestasi-sekolah.*') ? 'is-active' : '' }}" title="Prestasi">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span class="nav-text">Prestasi Siswa</span>
                    </a>
                </div>

                {{-- Group 3: RESOURCES --}}
                <div class="space-y-1">
                    <p class="sidebar-label px-2 mb-2 text-[0.65rem] font-bold text-slate-500 tracking-[0.15em] uppercase transition-opacity">SUMBER DAYA</p>
                    
                    <a href="{{ route('admin.guru.index') }}" class="nav-item {{ request()->routeIs('admin.guru.*') ? 'is-active' : '' }}" title="Guru & Staf">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span class="nav-text">Data Guru & Staf</span>
                    </a>

                    <a href="{{ route('admin.fasilitas.index') }}" class="nav-item {{ request()->routeIs('admin.fasilitas.*') ? 'is-active' : '' }}" title="Fasilitas">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="nav-text">Sarana Prasarana</span>
                    </a>

                    <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'is-active' : '' }}" title="Galeri">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="nav-text">Galeri Foto</span>
                    </a>
                </div>

                {{-- Group 4: COMMUNICATION --}}
                <div class="space-y-1">
                    <p class="sidebar-label px-2 mb-2 text-[0.65rem] font-bold text-slate-500 tracking-[0.15em] uppercase transition-opacity">INTERAKSI</p>
                    
                    @php $newsOpen = request()->routeIs('admin.articles.*') || request()->routeIs('admin.categories.*'); @endphp
                    <div class="sidebar-collapsible">
                        <button onclick="toggleSubmenu('submenu-news')" class="w-full nav-item {{ $newsOpen ? 'is-active' : '' }}" title="Berita">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <span class="nav-text flex-1 text-left">Berita & Artikel</span>
                            <svg id="arrow-news" class="w-3 h-3 nav-text transition-transform {{ $newsOpen ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div id="submenu-news" class="{{ $newsOpen ? 'block' : 'hidden' }} space-y-1 mt-1">
                            <a href="{{ route('admin.articles.index') }}" class="sidebar-sub-item block {{ request()->routeIs('admin.articles.index') ? 'is-active' : '' }}">Daftar Berita</a>
                            <a href="{{ route('admin.categories.index') }}" class="sidebar-sub-item block {{ request()->routeIs('admin.categories.index') ? 'is-active' : '' }}">Kategori</a>
                        </div>
                    </div>

                    <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}" title="Pesan">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span class="nav-text">Pesan Masuk</span>
                    </a>
                </div>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-slate-800/50 bg-slate-900/10 flex-shrink-0">
                <a href="{{ route('home') }}" target="_blank" class="nav-item group mb-2 hover:bg-cyan-500/10 hover:text-cyan-400" title="Buka Web">
                    <svg class="w-5 h-5 flex-shrink-0 text-cyan-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span class="nav-text sidebar-footer-text">Lihat Website</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" data-confirm="Yakin ingin logout?">
                    @csrf
                    <button type="submit" class="w-full nav-item group hover:bg-red-500/10 hover:text-red-400" title="Logout">
                        <svg class="w-5 h-5 flex-shrink-0 text-red-500 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="nav-text sidebar-footer-text">Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            
            {{-- Topbar --}}
            <header class="h-20 flex-shrink-0 bg-white border-b border-slate-200 px-6 lg:px-10 flex items-center justify-between z-30">
                <div class="flex items-center gap-4">
                    {{-- Toggle Button (Mobile & Desktop) --}}
                    <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-slate-100 text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="hidden sm:block">
                        <h1 class="text-xl font-bold text-slate-900 tracking-tight">@yield('heading', 'Dashboard')</h1>
                        <p class="text-[0.65rem] text-slate-500 font-bold uppercase tracking-wider">Admin Panel / SD N 2 Dermolo</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-slate-900 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[0.6rem] text-slate-500 mt-1">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm ring-4 ring-slate-50 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            {{-- Dynamic Viewport --}}
            <div class="flex-1 overflow-y-auto bg-slate-50/50 p-6 lg:p-10 custom-scrollbar">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Universal Modal --}}
    <div id="confirm-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" data-confirm-close="true"></div>
        <div class="relative w-full max-w-sm rounded-[1.25rem] bg-white shadow-2xl overflow-hidden border border-slate-100">
            <div class="p-8 text-center">
                <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-6 text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Konfirmasi Tindakan</h3>
                <p id="confirm-message" class="mt-2 text-sm text-slate-500 leading-relaxed">Apakah Anda yakin? Data yang dihapus mungkin tidak dapat dikembalikan.</p>
                
                <div class="mt-8 grid grid-cols-2 gap-3">
                    <button type="button" id="confirm-cancel" class="py-2.5 rounded-lg bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">Batal</button>
                    <button type="button" id="confirm-ok" class="py-2.5 rounded-lg bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition shadow-lg shadow-red-600/20">Hapus Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');
        
        // 1. Sidebar Toggle Logic (Desktop & Mobile)
        function toggleSidebar() {
            const isMobile = window.innerWidth < 1024;
            
            if (isMobile) {
                // Mobile: Slide In/Out
                sidebar.classList.toggle('mobile-sidebar-open');
                sidebar.classList.toggle('mobile-sidebar-closed');
                overlay.classList.toggle('hidden');
            } else {
                // Desktop: Expand/Collapse
                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                if (isCollapsed) {
                    sidebar.classList.replace('sidebar-collapsed', 'sidebar-expanded');
                    localStorage.setItem('sidebar_state', 'expanded');
                } else {
                    sidebar.classList.replace('sidebar-expanded', 'sidebar-collapsed');
                    localStorage.setItem('sidebar_state', 'collapsed');
                    // Close all submenus when collapsing
                    document.querySelectorAll('.sidebar-collapsible > div').forEach(d => d.classList.add('hidden'));
                }
            }
        }

        // 2. Initialize Sidebar State
        document.addEventListener('DOMContentLoaded', () => {
            const savedState = localStorage.getItem('sidebar_state');
            if (savedState === 'collapsed' && window.innerWidth >= 1024) {
                sidebar.classList.replace('sidebar-expanded', 'sidebar-collapsed');
            }

            // Mobile Overlay click
            overlay.addEventListener('click', toggleSidebar);
            toggleBtn.addEventListener('click', toggleSidebar);
        });

        // 3. Submenu Logic
        function toggleSubmenu(id) {
            if (sidebar.classList.contains('sidebar-collapsed')) {
                sidebar.classList.replace('sidebar-collapsed', 'sidebar-expanded');
                localStorage.setItem('sidebar_state', 'expanded');
            }
            const el = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id.split('-')[1]);
            el.classList.toggle('hidden');
            arrow?.classList.toggle('rotate-180');
        }

        // 4. Global Confirmation Logic
        const modal = document.getElementById('confirm-modal');
        const confirmOk = document.getElementById('confirm-ok');
        const confirmCancel = document.getElementById('confirm-cancel');
        let pendingForm = null;

        document.querySelectorAll('form[data-confirm]').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                pendingForm = form;
                document.getElementById('confirm-message').textContent = form.dataset.confirm;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        const closeModal = () => {
            pendingForm = null;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        confirmCancel.onclick = closeModal;
        confirmOk.onclick = () => { if (pendingForm) pendingForm.submit(); closeModal(); };
    </script>
    @stack('scripts')
    <script src="{{ asset('js/drop-zone.js') }}"></script>
</body>
</html>
