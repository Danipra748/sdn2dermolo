<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin SD N 2 Dermolo')</title>
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
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #94A3B8;
            font-weight: 600;
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            color: #CBD5E1;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .sidebar-summary:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }
        .sidebar-summary svg {
            width: 1rem;
            height: 1rem;
            transition: transform 0.2s ease;
        }
        .sidebar-summary::-webkit-details-marker { display: none; }
        summary.sidebar-summary::marker { content: ""; }
        details[open] > .sidebar-summary svg {
            transform: rotate(180deg);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1rem;
            border-radius: 10px;
            color: #94A3B8;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }
        .sidebar-link.is-active {
            background: #0EA5E9;
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }

        .sidebar-sub {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            padding: 0.5rem 0.5rem 0.75rem 0.5rem;
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
        }
        .btn-delete:hover {
            background: #DC2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            transform: translateY(-1px);
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
</head>
<body class="admin-bg text-slate-700 min-h-screen">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex w-72 sidebar">
            <div class="w-full p-6 flex flex-col gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @php
                        // Di sini lokasi penyimpanan path logonya.
                        $logoMatches = glob(storage_path('app/public/logos/sd-negeri-2-dermolo.*')) ?: [];
                        $logoPath = $logoMatches[0] ?? null;
                        $logoExists = $logoPath !== null;
                        $logoAsset = $logoExists ? asset('storage/logos/' . basename($logoPath)) : null;
                    @endphp

                    @if($logoExists)
                        <img src="{{ $logoAsset }}"
                             alt="Logo SD N 2 Dermolo"
                             class="w-12 h-12 rounded-xl object-contain bg-white p-1.5 shadow-sm group-hover:shadow-md transition">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-cyan text-white flex items-center justify-center font-bold text-sm group-hover:bg-cyan-light transition">SD</div>
                    @endif

                    <div>
                        <p class="text-base font-semibold text-white group-hover:text-cyan-light transition">Admin Panel</p>
                        <p class="text-xs text-slate-400">SD N 2 Dermolo</p>
                    </div>
                </a>

                @php
                    $ringkasanOpen = request()->routeIs('admin.dashboard');
                    $kontenOpen = request()->routeIs('admin.fasilitas.*')
                        || request()->routeIs('admin.guru.*')
                        || request()->routeIs('admin.program-sekolah.*')
                        || request()->routeIs('admin.prestasi-sekolah.*')
                        || request()->routeIs('admin.articles.*')
                        || request()->routeIs('admin.categories.*')
                        || request()->routeIs('admin.messages.*');
                @endphp

                <nav class="flex flex-col gap-5 text-sm overflow-y-auto flex-1">
                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Ringkasan</div>
                        <details class="rounded-xl" {{ $ringkasanOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </div>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        <span>Dashboard</span>
                                    </div>
                                    @if (request()->routeIs('admin.dashboard'))
                                        <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full">Utama</span>
                                    @endif
                                </a>
                            </div>
                        </details>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Konten Publik</div>
                        <details class="rounded-xl" {{ $kontenOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                    <span>Kelola Konten</span>
                                </div>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.homepage.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.homepage.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <span>Pengaturan Beranda</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.school-profile.edit') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.school-profile.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>Profil Sekolah</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.fasilitas.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.fasilitas.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>Data Fasilitas</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.guru.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.guru.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M4.262 14.414C2.478 16.848 2.882 17.323 5.448 17.792c6.112 1.12 11.296-2.328 13.324-5.424 1.38-2.107 1.033-3.087-1.148-4.324-.68-.386-1.387-.72-2.11-1.002m-3.864-1.292c-2.98-.89-5.97-.536-6.842 1.34-.872 1.877.857 4.62 3.837 5.51 2.98.888 5.97.535 6.842-1.342.872-1.876-.857-4.62-3.837-5.508z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>Data Guru</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.program-sekolah.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.program-sekolah.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span>Program Sekolah</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.prestasi-sekolah.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.prestasi-sekolah.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                        <span>Prestasi Sekolah</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.articles.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span>Artikel & News</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span>Kategori Artikel</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.messages.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                                    <div class="flex items-center gap-2.5">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Pesan Masuk</span>
                                    </div>
                                </a>
                            </div>
                        </details>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Sistem</div>
                        <details class="rounded-xl">
                            <summary class="sidebar-summary">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Pengaturan</span>
                                </div>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <form action="{{ route('logout') }}" method="POST" data-confirm="Yakin ingin logout?">
                                    @csrf
                                    <button type="submit" class="sidebar-link w-full text-left">
                                        <div class="flex items-center gap-2.5">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            <span>Logout</span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </details>
                    </div>

                    <a href="{{ route('home') }}" class="sidebar-link mt-2 border border-slate-600/50 border-dashed" target="_blank">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span>Lihat Website</span>
                        </div>
                    </a>
                </nav>

                <div class="mt-auto pt-6">
                    <div class="rounded-xl border border-dashed border-slate-600 p-4 text-xs text-slate-400">
                        Status Sistem
                        <p class="mt-2 font-semibold text-slate-300 badge-dot">Aktif</p>
                        <p class="mt-2">Terakhir diperbarui: {{ date('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col">
            <header class="topbar">
                <div class="px-6 lg:px-10 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400 mb-1">Panel Admin</p>
                        <h1 class="text-2xl md:text-3xl font-semibold text-white">@yield('heading', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-cyan text-white flex items-center justify-center font-semibold text-base shadow-lg">
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

    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/70" data-confirm-close="true"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-800 text-center">Konfirmasi</h3>
                <p id="confirm-message" class="mt-3 text-sm text-slate-600 text-center">Apakah Anda yakin ingin menghapus data ini?</p>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" id="confirm-cancel"
                            class="px-6 py-2.5 rounded-xl border border-slate-300 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="button" id="confirm-ok"
                            class="px-6 py-2.5 rounded-xl bg-coral text-white text-sm font-medium hover:bg-red-600 transition">
                        Hapus
                    </button>
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
                if (pendingForm) {
                    pendingForm.submit();
                }
                closeModal();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
