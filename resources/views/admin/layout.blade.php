<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin SD N 2 Dermolo')</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --ink: #0f172a;
            --slate: #1f2937;
            --mist: #f8fafc;
            --sky: #0ea5e9;
            --leaf: #22c55e;
            --sun: #f59e0b;
            --berry: #ef4444;
        }
        body { font-family: "Work Sans", system-ui, sans-serif; }
        h1, h2, h3, .brand { font-family: "Space Grotesk", system-ui, sans-serif; }
        .admin-bg {
            background: radial-gradient(60rem 60rem at -10% -20%, rgba(14,165,233,0.15), transparent 60%),
                        radial-gradient(50rem 50rem at 110% -10%, rgba(34,197,94,0.12), transparent 60%),
                        linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        }
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148,163,184,0.3);
        }
        .metric-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.6));
            border: 1px solid rgba(148,163,184,0.25);
        }
        .badge-dot::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: var(--leaf);
            display: inline-block;
            margin-right: 8px;
        }
    </style>
    @stack('styles')
</head>
<body class="admin-bg text-slate-900 min-h-screen">
    <div class="min-h-screen flex">
        <aside class="hidden lg:flex w-72 p-6">
            <div class="glass rounded-3xl w-full p-6 flex flex-col gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-sky-500 text-white flex items-center justify-center font-bold">SD</div>
                    <div>
                        <p class="brand text-lg text-slate-900">Admin Panel</p>
                        <p class="text-xs text-slate-500">SD N 2 Dermolo</p>
                    </div>
                </div>

                <nav class="flex flex-col gap-3 text-sm">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        <span>Dashboard</span>
                        @if (request()->routeIs('admin.dashboard'))
                            <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Utama</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.fasilitas.index') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.fasilitas.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Data Fasilitas
                    </a>
                    <a href="{{ route('admin.guru.index') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.guru.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Data Guru
                    </a>
                    <a href="{{ route('admin.program-sekolah.index') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.program-sekolah.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Program Sekolah
                    </a>
                    <a href="{{ route('admin.prestasi-sekolah.index') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.prestasi-sekolah.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Prestasi Sekolah
                    </a>
                    <a href="{{ route('admin.articles.index') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.articles.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Artikel & News
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.categories.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Kategori Artikel & News
                    </a>
                    <a href="{{ route('admin.sambutan-kepsek.edit') }}"
                       class="px-4 py-3 rounded-2xl {{ request()->routeIs('admin.sambutan-kepsek.*') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 transition' }}">
                        Sambutan Kepsek
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 transition">Logout</button>
                    </form>
                </nav>

                <div class="mt-auto">
                    <div class="rounded-2xl border border-dashed border-slate-300 p-4 text-xs text-slate-500">
                        Status Sistem
                        <p class="mt-2 font-semibold text-slate-800 badge-dot">Aktif</p>
                        <p class="mt-2">Terakhir diperbarui: {{ date('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1">
            <header class="px-6 lg:px-10 pt-8">
                <div class="glass rounded-3xl px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Panel Admin</p>
                        <h1 class="text-2xl md:text-3xl font-semibold text-slate-900">@yield('heading', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-slate-900 text-white flex items-center justify-center font-semibold">A</div>
                    </div>
                </div>
            </header>

            <section class="px-6 lg:px-10 py-8">
                @yield('content')
            </section>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
