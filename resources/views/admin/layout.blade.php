<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin SD N 2 Dermolo')</title>
    
    {{-- Resource Hints --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#1E293B',
                            light: '#334155',
                            dark: '#0F172A'
                        },
                        cyan: {
                            DEFAULT: '#0EA5E9',
                            light: '#38BDF8',
                            dark: '#0284C7'
                        },
                        accent: {
                            green: '#10B981',
                            orange: '#F59E0B',
                            coral: '#EF4444'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        'card': '12px',
                    },
                    boxShadow: {
                        'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                        'card': '0 4px 16px rgba(0, 0, 0, 0.06)',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 { 
            font-family: 'Inter', system-ui, sans-serif;
            font-weight: 600;
            line-height: 1.3;
        }

        /* Clean background gradient */
        .admin-bg {
            background: linear-gradient(180deg, #F8FAFC 0%, #F1F5F9 100%);
        }

        /* Modern card with soft shadow */
        .modern-card {
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #E2E8F0;
            transition: all 0.2s ease;
        }

        .modern-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Metric card styling */
        .metric-card {
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #E2E8F0;
            padding: 24px;
            transition: all 0.2s ease;
        }

        .metric-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Badge dot indicator */
        .badge-dot::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #10B981;
            display: inline-block;
            margin-right: 8px;
        }

        /* Sidebar styles - Modern Navy theme */
        .sidebar {
            background: #0F172A; /* Deeper navy */
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-label {
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #64748B;
            font-weight: 700;
            padding: 1.5rem 1rem 0.5rem;
        }

        .sidebar-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: #94A3B8;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            user-select: none;
        }
        .sidebar-summary:hover {
            background: rgba(255, 255, 255, 0.03);
            color: #F8FAFC;
        }
        .sidebar-summary svg:last-child {
            width: 0.9rem;
            height: 0.9rem;
            transition: transform 0.3s ease;
            color: #475569;
        }
        .sidebar-summary::-webkit-details-marker { display: none; }
        summary.sidebar-summary::marker { content: ""; }
        details[open] > .sidebar-summary {
            color: #F8FAFC;
        }
        details[open] > .sidebar-summary svg:last-child {
            transform: rotate(180deg);
            color: #0EA5E9;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: #94A3B8;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            margin: 0.1rem 0;
            position: relative;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #F8FAFC;
            transform: translateX(4px);
        }
        .sidebar-link.is-active {
            background: rgba(14, 165, 233, 0.1);
            color: #0EA5E9;
            font-weight: 600;
        }
        .sidebar-link.is-active::before {
            content: "";
            position: absolute;
            left: -1rem;
            top: 0.75rem;
            bottom: 0.75rem;
            width: 4px;
            background: #0EA5E9;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 12px rgba(14, 165, 233, 0.5);
        }

        .sidebar-sub {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            padding: 0.25rem 0.5rem 0.5rem 1.25rem;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            margin-left: 1.5rem;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
        }

        /* Topbar styling - Modern Dark */
        .topbar {
            background: #0F172A;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        /* Mobile sidebar overlay */
        #mobile-overlay {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(4px);
            z-index: 45;
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Button styles */
        .btn-primary {
            background: #10B981;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #059669;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transform: translateY(-1px);
        }

        .btn-edit {
            background: #F59E0B;
            color: white;
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-edit:hover {
            background: #D97706;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            transform: translateY(-1px);
        }

        .btn-delete {
            background: #EF4444;
            color: white;
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 13px;
            opacity: 1 !important;
            display: inline-block !important;
            visibility: visible !important;
        }
        .btn-delete:hover {
            background: #DC2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            transform: translateY(-1px);
        }

        /* 
         * GLOBAL DELETE BUTTON FIX - Force all delete buttons to be visible
         * Fix untuk semua tombol hapus yang tersembunyi di berbagai halaman
         * Target: Gallery, Prestasi, Fasilitas, Program Photos, dll.
         */
        form button[type="submit"],
        form button[class*="Hapus"],
        button[class*="hapus"],
        button[class*="delete"] {
            opacity: 1 !important;
            display: inline-block !important;
            visibility: visible !important;
        }

        /* Force delete buttons in forms to be red and visible */
        form[action*="destroy"] button[type="submit"],
        form[method="POST"] button[type="submit"] {
            opacity: 1 !important;
        }

        /* Specific fix for white delete buttons */
        button.bg-white.border-slate-200,
        button[class*="bg-white"][class*="border-slate"] {
            background: #EF4444 !important;
            color: white !important;
            border-color: #EF4444 !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        button.bg-white.border-slate-200:hover,
        button[class*="bg-white"][class*="border-slate"]:hover {
            background: #DC2626 !important;
            border-color: #DC2626 !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }

        .btn-secondary {
            background: #FFFFFF;
            color: #475569;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #E2E8F0;
            cursor: pointer;
        }
        .btn-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }

        /* 
         * MODAL CONFIRMATION BUTTON FIX
         * Fix untuk tombol 'Hapus' di modal konfirmasi yang tersembunyi
         * Pastikan selalu terlihat dengan warna merah yang kontras
         */
        #confirm-ok {
            background-color: #DC2626 !important;      /* Merah gelap - selalu terlihat */
            color: #FFFFFF !important;                  /* Teks putih */
            border: 2px solid #DC2626 !important;       /* Border merah */
            opacity: 1 !important;                      /* Selalu visible */
            visibility: visible !important;             /* Selalu visible */
            display: inline-block !important;           /* Selalu block */
            font-weight: 600 !important;                /* Bold untuk emphasis */
            cursor: pointer !important;                 /* Cursor pointer */
            transition: all 0.2s ease !important;       /* Smooth transition */
        }

        #confirm-ok:hover {
            background-color: #B91C1C !important;       /* Lebih gelap saat hover */
            border-color: #B91C1C !important;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4) !important;
            transform: translateY(-1px);
        }

        #confirm-cancel {
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

        #confirm-cancel:hover {
            background-color: #F1F5F9 !important;
            border-color: #94A3B8 !important;
            color: #1E293B !important;
        }

        /* Force modal container to always show buttons properly */
        #confirm-modal button[type="button"] {
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
        }

        /* Prevent any inheritance that might hide modal buttons */
        #confirm-modal .flex button,
        #public-confirm-modal .flex button {
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Table styling with alternating rows */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .modern-table thead th {
            background: #F8FAFC;
            color: #64748B;
            font-weight: 600;
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #E2E8F0;
        }
        .modern-table tbody tr {
            transition: background 0.15s ease;
        }
        .modern-table tbody tr:nth-child(even) {
            background: #F8FAFC;
        }
        .modern-table tbody tr:hover {
            background: #F1F5F9;
        }
        .modern-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #E2E8F0;
            color: #334155;
        }

        /* Form input styling */
        .form-input {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }
        .form-input:focus {
            outline: none;
            border-color: #0EA5E9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            margin-bottom: 8px;
        }

        /* Section card */
        .section-card {
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #E2E8F0;
            padding: 32px;
        }

        /* Alert styling */
        .alert-success {
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            border-radius: 12px;
            padding: 16px 20px;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }
    </style>
    @stack('styles')
    
    {{-- Global Drop Zone Styles --}}
    <link rel="stylesheet" href="{{ asset('css/drop-zone.css') }}">
</head>
<body class="admin-bg text-slate-700 min-h-screen">
    {{-- Mobile Sidebar Overlay --}}
    <div id="mobile-overlay" class="fixed inset-0 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 sidebar lg:static lg:translate-x-0 -translate-x-full z-50 flex flex-col">
            <div class="p-6 flex flex-col h-full">
                {{-- Logo & Brand --}}
                <div class="mb-8 px-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        @php
                            $logoMatches = glob(storage_path('app/public/logos/sd-negeri-2-dermolo.*')) ?: [];
                            $logoPath = $logoMatches[0] ?? null;
                            $logoExists = $logoPath !== null;
                            $logoAsset = $logoExists ? asset('storage/logos/' . basename($logoPath)) : null;
                        @endphp

                        @if($logoExists)
                            <img src="{{ $logoAsset }}"
                                 alt="Logo SD N 2 Dermolo"
                                 class="w-10 h-10 rounded-xl object-contain bg-white p-1 shadow-sm group-hover:shadow-md transition duration-300">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-lg group-hover:bg-blue-500 transition duration-300">SD</div>
                        @endif

                        <div>
                            <p class="text-sm font-bold text-white group-hover:text-blue-400 transition">Admin Panel</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest">SD N 2 Dermolo</p>
                        </div>
                    </a>
                </div>

                @php
                    // Helper to check active groups
                    $isInfoOpen = request()->routeIs('admin.school-profile.*') || request()->routeIs('admin.hero-slides.*') || request()->routeIs('admin.hidden-settings') || request()->routeIs('admin.sambutan-kepsek.*');
                    $isAkademikOpen = request()->routeIs('admin.guru.*') || request()->routeIs('admin.program-sekolah.*') || request()->routeIs('admin.ppdb.*');
                    $isMediaOpen = request()->routeIs('admin.articles.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.gallery.*') || request()->routeIs('admin.prestasi-sekolah.*') || request()->routeIs('admin.fasilitas.*');
                @endphp

                <nav class="flex-1 sidebar-nav overflow-y-auto pr-1">
                    {{-- Section: General --}}
                    <div class="mb-4">
                        <a href="{{ route('admin.dashboard') }}"
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-home class="w-5 h-5" />
                                <span>Dashboard</span>
                            </div>
                        </a>
                    </div>

                    {{-- Section: Informasi Sekolah --}}
                    <div class="mb-2">
                        <div class="sidebar-label">Informasi Sekolah</div>
                        <details class="group" {{ $isInfoOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary">
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-building-office-2 class="w-5 h-5" />
                                    <span>Profil & Banner</span>
                                </div>
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.school-profile.edit') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.school-profile.*') ? 'is-active' : '' }}">
                                    <span>Identitas Sekolah</span>
                                </a>
                                <a href="{{ route('admin.hero-slides.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.hero-slides.*') ? 'is-active' : '' }}">
                                    <span>Hero Slideshow</span>
                                </a>
                                <a href="{{ route('admin.sambutan-kepsek.edit') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.sambutan-kepsek.*') ? 'is-active' : '' }}">
                                    <span>Sambutan Kepsek</span>
                                </a>
                                <a href="{{ route('admin.hidden-settings') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.hidden-settings') ? 'is-active' : '' }}">
                                    <span>Foto Pejabat</span>
                                </a>
                            </div>
                        </details>
                    </div>

                    {{-- Section: Akademik --}}
                    <div class="mb-2">
                        <div class="sidebar-label">Akademik</div>
                        <details class="group" {{ $isAkademikOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary">
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-academic-cap class="w-5 h-5" />
                                    <span>Pendidikan</span>
                                </div>
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.guru.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.guru.*') ? 'is-active' : '' }}">
                                    <span>Data Guru & Staff</span>
                                </a>
                                <a href="{{ route('admin.program-sekolah.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.program-sekolah.*') ? 'is-active' : '' }}">
                                    <span>Program Sekolah</span>
                                </a>
                                <a href="{{ route('admin.ppdb.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.ppdb.*') ? 'is-active' : '' }}">
                                    <span>Penerimaan Siswa (PPDB)</span>
                                </a>
                            </div>
                        </details>
                    </div>

                    {{-- Section: Media & Konten --}}
                    <div class="mb-2">
                        <div class="sidebar-label">Media & Konten</div>
                        <details class="group" {{ $isMediaOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary">
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-photo class="w-5 h-5" />
                                    <span>Publikasi</span>
                                </div>
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.articles.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}">
                                    <span>Berita & Artikel</span>
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                                    <span>Kategori Berita</span>
                                </a>
                                <a href="{{ route('admin.gallery.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.gallery.*') ? 'is-active' : '' }}">
                                    <span>Galeri Foto</span>
                                </a>
                                <a href="{{ route('admin.prestasi-sekolah.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.prestasi-sekolah.*') ? 'is-active' : '' }}">
                                    <span>Prestasi Siswa</span>
                                </a>
                                <a href="{{ route('admin.fasilitas.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.fasilitas.*') ? 'is-active' : '' }}">
                                    <span>Sarana Prasarana</span>
                                </a>
                            </div>
                        </details>
                    </div>

                    {{-- Section: Komunikasi --}}
                    <div class="mb-4">
                        <div class="sidebar-label">Komunikasi</div>
                        <a href="{{ route('admin.messages.index') }}"
                           class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                                <span>Pesan Masuk</span>
                            </div>
                        </a>
                    </div>
                </nav>

                {{-- Sidebar Footer --}}
                <div class="mt-auto pt-6 border-t border-white/5">
                    <div class="mb-4">
                        <a href="{{ route('home') }}" target="_blank" class="sidebar-link group/link hover:bg-blue-600/10">
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-globe-alt class="w-5 h-5 text-slate-500 group-hover/link:text-blue-400" />
                                <span class="text-sm">Lihat Website</span>
                            </div>
                            <x-heroicon-o-arrow-top-right-on-square class="w-3.5 h-3.5 opacity-0 group-hover/link:opacity-100 transition" />
                        </a>
                    </div>

                    <div class="bg-slate-800/30 rounded-2xl p-4 border border-white/5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Sistem</span>
                            <span class="flex h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <button type="button" 
                                    onclick="confirmLogout()"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-slate-400 hover:text-red-400 hover:bg-red-400/10 transition group/logout">
                                <x-heroicon-o-power class="w-5 h-5 group-hover/logout:scale-110 transition duration-300" />
                                <span class="text-sm font-semibold">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0">
            <header class="topbar">
                <div class="px-6 lg:px-10 py-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden text-slate-400 hover:text-white transition">
                            <x-heroicon-o-bars-3-bottom-left class="w-7 h-7" />
                        </button>
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.25em] text-slate-500 mb-0.5">Administrator</p>
                            <h1 class="text-xl md:text-2xl font-bold text-white truncate">@yield('heading', 'Dashboard')</h1>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3 md:gap-6">
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="relative group">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center font-bold text-base shadow-lg group-hover:shadow-blue-500/20 transition duration-300 ring-2 ring-white/5 group-hover:ring-blue-500/50">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="px-6 lg:px-10 py-8 flex-1">
                @yield('content')
            </section>
        </main>
    </div>

    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/70" data-confirm-close="true"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 text-center">Konfirmasi Hapus</h3>
                <p id="confirm-message" class="mt-3 text-sm text-slate-600 text-center">Apakah Anda yakin ingin menghapus data ini?</p>
                
                <div class="mt-6 flex items-center justify-center gap-4">
                    <button type="button" 
                            id="confirm-cancel"
                            class="px-8 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                        Batal
                    </button>
                    <button type="button" 
                            id="confirm-ok"
                            class="px-8 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                        <svg class="inline-block w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 4m8 4V6m0 0L11 4m2 2h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Logout Confirmation
        function confirmLogout() {
            if (confirm('Yakin ingin keluar dari sistem?')) {
                document.getElementById('logout-form').submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('confirm-modal');
            const message = document.getElementById('confirm-message');
            const confirmOk = document.getElementById('confirm-ok');
            const confirmCancel = document.getElementById('confirm-cancel');
            let pendingForm = null;

            document.querySelectorAll('form[data-confirm]').forEach((form) => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    pendingForm = form;
                    message.textContent = form.dataset.confirm || 'Apakah Anda yakin?';
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            const closeModal = () => {
                pendingForm = null;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            confirmCancel?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (event) => {
                if (event.target?.dataset?.confirmClose) {
                    closeModal();
                }
            });
            confirmOk?.addEventListener('click', () => {
                if (pendingForm) {
                    pendingForm.submit();
                }
                closeModal();
            });
        });
    </script>

    @stack('scripts')
    
    {{-- Global Drop Zone Script --}}
    <script src="{{ asset('js/drop-zone.js') }}"></script>
</body>
</html>
