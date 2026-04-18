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

        /* Sidebar styles - Navy theme */
        .sidebar {
            background: #1E293B;
            border-right: 1px solid #334155;
        }

        .sidebar-label {
            font-size: 0.65rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #64748B;
            font-weight: 700;
            padding: 0 1rem;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .sidebar-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: #CBD5E1;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .sidebar-summary:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #FFFFFF;
        }
        .sidebar-summary svg {
            width: 1rem;
            height: 1rem;
            transition: transform 0.2s ease;
        }
        .sidebar-summary::-webkit-details-marker { display: none; }
        summary.sidebar-summary::marker { content: ""; }
        details[open] > .sidebar-summary svg:last-child {
            transform: rotate(180deg);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            color: #94A3B8;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #FFFFFF;
        }
        .sidebar-link.is-active {
            background: #0EA5E9;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
        }
        .sidebar-link.is-active svg {
            color: #FFFFFF !important;
        }

        .sidebar-sub {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0.5rem 0.5rem 0.5rem 1rem;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            margin-left: 1.5rem;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-sub-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            color: #64748B;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }
        .sidebar-sub-link:hover {
            color: #FFFFFF;
            background: rgba(255, 255, 255, 0.04);
        }
        .sidebar-sub-link.is-active {
            color: #38BDF8;
            font-weight: 600;
        }

        /* Topbar styling */
        .topbar {
            background: #1E293B;
            border-bottom: 1px solid #334155;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        form button[type="submit"],
        form button[class*="Hapus"],
        button[class*="hapus"],
        button[class*="delete"] {
            opacity: 1 !important;
            display: inline-block !important;
            visibility: visible !important;
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

        #confirm-ok {
            background-color: #DC2626 !important;
            color: #FFFFFF !important;
            border: 2px solid #DC2626 !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        #confirm-ok:hover {
            background-color: #B91C1C !important;
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

        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
    </style>
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/drop-zone.css') }}">
</head>
<body class="admin-bg text-slate-700 min-h-screen overflow-x-hidden">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex w-72 sidebar sticky top-0 h-screen overflow-y-auto">
            <div class="w-full py-8 px-6 flex flex-col min-h-full">
                {{-- Logo/Brand --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group mb-2">
                    @php
                        $logoMatches = glob(storage_path('app/public/logos/sd-negeri-2-dermolo.*')) ?: [];
                        $logoPath = $logoMatches[0] ?? null;
                        $logoExists = $logoPath !== null;
                        $logoAsset = $logoExists ? asset('storage/logos/' . basename($logoPath)) : null;
                    @endphp

                    @if($logoExists)
                        <img src="{{ $logoAsset }}"
                             alt="Logo"
                             class="w-10 h-10 rounded-lg object-contain bg-white p-1 shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-cyan text-white flex items-center justify-center font-bold text-xs">SD</div>
                    @endif

                    <div>
                        <p class="text-sm font-bold text-white leading-tight">Admin SD N 2</p>
                        <p class="text-[0.65rem] text-slate-400 font-medium tracking-wider">PANEL KONTEN</p>
                    </div>
                </a>

                <nav class="flex flex-col flex-1">
                    {{-- 1. UTAMA --}}
                    <div class="sidebar-label">NAVIGASI UTAMA</div>
                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.school-profile.edit') }}"
                       class="sidebar-link {{ request()->routeIs('admin.school-profile.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Profil Sekolah</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.hidden-settings') }}"
                       class="sidebar-link {{ request()->routeIs('admin.hidden-settings') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>Sambutan & Foto Kepsek</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.hero-slides.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.hero-slides.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Slideshow Beranda</span>
                        </div>
                    </a>

                    {{-- 2. AKADEMIK --}}
                    <div class="sidebar-label">AKADEMIK & KESISWAAN</div>
                    <a href="{{ route('admin.ppdb.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.ppdb.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Penerimaan (PPDB)</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.program-sekolah.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.program-sekolah.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Program Sekolah</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.prestasi-sekolah.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.prestasi-sekolah.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            <span>Prestasi Sekolah</span>
                        </div>
                    </a>

                    {{-- 3. ASET --}}
                    <div class="sidebar-label">SUMBER DAYA & FASILITAS</div>
                    <a href="{{ route('admin.guru.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.guru.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Data Guru & Staf</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.fasilitas.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.fasilitas.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Sarana & Prasarana</span>
                        </div>
                    </a>

                    <a href="{{ route('admin.gallery.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.gallery.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Galeri Foto</span>
                        </div>
                    </a>

                    {{-- 4. INFORMASI --}}
                    <div class="sidebar-label">INFORMASI & LAYANAN</div>
                    @php $beritaOpen = request()->routeIs('admin.articles.*') || request()->routeIs('admin.categories.*'); @endphp
                    <details class="rounded-xl" {{ $beritaOpen ? 'open' : '' }}>
                        <summary class="sidebar-summary">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span>Berita & Artikel</span>
                            </div>
                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="sidebar-sub">
                            <a href="{{ route('admin.articles.index') }}"
                               class="sidebar-sub-link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}">
                                Daftar Artikel
                            </a>
                            <a href="{{ route('admin.categories.index') }}"
                               class="sidebar-sub-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                                Kategori Berita
                            </a>
                        </div>
                    </details>

                    <a href="{{ route('admin.messages.index') }}"
                       class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>Pesan Masuk</span>
                        </div>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" data-confirm="Yakin ingin logout?" class="mt-4">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left text-red-400 hover:bg-red-500/10 hover:text-red-300">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </nav>

                {{-- Bottom Section --}}
                <div class="mt-8 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-800 text-xs text-white hover:bg-slate-700 transition font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Lihat Website
                    </a>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col min-h-screen">
            <header class="topbar sticky top-0 z-30">
                <div class="px-6 lg:px-10 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-1">Panel Admin</p>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">@yield('heading', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-[0.65rem] text-slate-400 font-medium">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan to-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <section class="px-6 lg:px-10 py-8 flex-1">
                @yield('content')
            </section>
        </main>
    </div>

    {{-- Confirmation Modal --}}
    <div id="confirm-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" data-confirm-close="true"></div>
        <div class="relative w-full max-w-sm rounded-3xl bg-white shadow-2xl overflow-hidden border border-slate-100">
            <div class="p-8">
                <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-red-50 mx-auto mb-6">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 text-center">Konfirmasi</h3>
                <p id="confirm-message" class="mt-2 text-slate-500 text-center leading-relaxed">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                
                <div class="mt-8 grid grid-cols-2 gap-3">
                    <button type="button" id="confirm-cancel" class="px-4 py-3 rounded-2xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition">Batal</button>
                    <button type="button" id="confirm-ok" class="px-4 py-3 rounded-2xl bg-red-600 text-white font-bold hover:bg-red-700 transition shadow-lg shadow-red-600/30">Ya, Lanjut</button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                if (pendingForm) pendingForm.submit();
                closeModal();
            });
        });
    </script>
    @stack('scripts')
    <script src="{{ asset('js/drop-zone.js') }}"></script>
</body>
</html>
