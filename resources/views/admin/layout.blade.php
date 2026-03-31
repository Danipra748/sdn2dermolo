<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin SD N 2 Dermolo')</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: "Work Sans", system-ui, sans-serif; }
        h1, h2, h3, .brand { font-family: "Space Grotesk", system-ui, sans-serif; }

        /* Admin background gradient */
        .admin-bg {
            background: radial-gradient(60rem 60rem at -10% -20%, rgba(14,165,233,0.15), transparent 60%),
                        radial-gradient(50rem 50rem at 110% -10%, rgba(34,197,94,0.12), transparent 60%),
                        linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        }

        /* Glass effect */
        .glass {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148,163,184,0.3);
        }

        /* Metric card */
        .metric-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.6));
            border: 1px solid rgba(148,163,184,0.25);
        }

        /* Badge dot indicator */
        .badge-dot::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #22c55e;
            display: inline-block;
            margin-right: 8px;
        }

        /* Sidebar styles */
        .sidebar-label {
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 600;
            padding: 0 0.5rem;
        }

        .sidebar-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            border-radius: 1rem;
            color: #475569;
            font-weight: 600;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .sidebar-summary:hover {
            background: rgba(15, 23, 42, 0.06);
            color: #0f172a;
        }
        .sidebar-summary svg {
            width: 0.9rem;
            height: 0.9rem;
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
            padding: 0.6rem 1rem;
            border-radius: 0.95rem;
            color: #64748b;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .sidebar-link:hover {
            background: rgba(15, 23, 42, 0.06);
            color: #0f172a;
        }
        .sidebar-link.is-active {
            background: #0f172a;
            color: #fff;
        }

        .sidebar-sub {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            padding: 0.4rem 0.25rem 0.6rem 0.25rem;
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

                @php
                    $ringkasanOpen = request()->routeIs('admin.dashboard');
                    $landingOpen = request()->routeIs('admin.sambutan-kepsek.*') || request()->routeIs('admin.kontak.*');
                    $kontenOpen = request()->routeIs('admin.fasilitas.*')
                        || request()->routeIs('admin.guru.*')
                        || request()->routeIs('admin.program-sekolah.*')
                        || request()->routeIs('admin.prestasi-sekolah.*')
                        || request()->routeIs('admin.articles.*')
                        || request()->routeIs('admin.categories.*')
                        || request()->routeIs('admin.messages.*');
                @endphp

                <nav class="flex flex-col gap-4 text-sm">
                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Ringkasan</div>
                        <details class="rounded-2xl" {{ $ringkasanOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary cursor-pointer">
                                <span>Dashboard</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.dashboard') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                                    <span>Dashboard</span>
                                    @if (request()->routeIs('admin.dashboard'))
                                        <span class="text-xs bg-white/20 px-2 py-1 rounded-full">Utama</span>
                                    @endif
                                </a>
                            </div>
                        </details>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Landing Page</div>
                        <details class="rounded-2xl" {{ $landingOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary cursor-pointer">
                                <span>Pengantar</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.sambutan-kepsek.edit') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.sambutan-kepsek.*') ? 'is-active' : '' }}">
                                    Sambutan Kepsek
                                </a>
                                <a href="{{ route('admin.kontak.edit') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.kontak.*') ? 'is-active' : '' }}">
                                    Kontak Sekolah
                                </a>
                            </div>
                        </details>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Konten Publik</div>
                        <details class="rounded-2xl" {{ $kontenOpen ? 'open' : '' }}>
                            <summary class="sidebar-summary cursor-pointer">
                                <span>Kelola Konten</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <a href="{{ route('admin.fasilitas.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.fasilitas.*') ? 'is-active' : '' }}">
                                    Data Fasilitas
                                </a>
                                <a href="{{ route('admin.guru.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.guru.*') ? 'is-active' : '' }}">
                                    Data Guru
                                </a>
                                <a href="{{ route('admin.program-sekolah.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.program-sekolah.*') ? 'is-active' : '' }}">
                                    Program Sekolah
                                </a>
                                <a href="{{ route('admin.prestasi-sekolah.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.prestasi-sekolah.*') ? 'is-active' : '' }}">
                                    Prestasi Sekolah
                                </a>
                                <a href="{{ route('admin.articles.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}">
                                    Artikel & News
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                                    Kategori Artikel & News
                                </a>
                                <a href="{{ route('admin.messages.index') }}"
                                   class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                                    Pesan Masuk
                                </a>
                            </div>
                        </details>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="sidebar-label">Sistem</div>
                        <details class="rounded-2xl">
                            <summary class="sidebar-summary cursor-pointer">
                                <span>Pengaturan</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="sidebar-sub">
                                <form action="{{ route('logout') }}" method="POST" data-confirm="Yakin ingin logout?">
                                    @csrf
                                    <button type="submit" class="sidebar-link w-full text-left">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </details>
                    </div>
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

    <div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" data-confirm-close="true"></div>
        <div class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
            <h3 class="text-lg font-semibold text-slate-900">Konfirmasi Hapus</h3>
            <p id="confirm-message" class="mt-2 text-sm text-slate-600">Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="mt-6 flex items-center justify-end gap-2">
                <button type="button" id="confirm-cancel"
                        class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="button" id="confirm-ok"
                        class="px-4 py-2 rounded-2xl bg-rose-600 text-white text-sm hover:bg-rose-700 transition">
                    Hapus
                </button>
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
