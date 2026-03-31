<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SD N 2 Dermolo')</title>
    @if (trim($__env->yieldContent('meta_description')))
        <meta name="description" content="@yield('meta_description')">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
        .animate-fadeInUp   { animation: fadeInUp 0.8s ease-out; }
        .animate-bounce     { animation: bounce 2s infinite; }
        .animate-float      { animation: float 3s ease-in-out infinite; }
        .animate-fadeIn     { animation: fadeIn 0.6s ease-in; }
        .card-hover         { transition: all 0.3s ease; }
        .card-hover:hover   { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,.1); }
        .teacher-card       { transition: all 0.3s ease; }
        .teacher-card:hover { transform: scale(1.05); }
        :root {
            --nav-bg: #f8fafc;
            --nav-border: #e2e8f0;
            --nav-text: #0f172a;
            --nav-muted: #64748b;
            --nav-accent: #1a56db;
            --nav-accent-2: #10b981;
            --nav-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .navbar {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            border-bottom: 1px solid var(--nav-border);
            position: fixed;
            inset: 0 0 auto 0;
            z-index: 50;
            box-shadow: var(--nav-shadow);
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem 0 3.5rem;
            height: 76px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 1.5rem;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.9rem;
        }
        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--nav-accent), #3b82f6);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.02em;
            box-shadow: 0 8px 20px rgba(26, 86, 219, 0.25);
        }
        .brand-title { font-weight: 800; color: var(--nav-text); line-height: 1.1; }
        .brand-sub { font-size: 0.62rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--nav-muted); }
        .nav-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.4rem;
            font-weight: 600;
            color: var(--nav-muted);
            margin-left: 2.5rem;
        }
        .nav-link {
            position: relative;
            padding: 0.45rem 0.65rem;
            transition: color 0.25s ease, background 0.25s ease;
            border-radius: 999px;
        }
        .nav-link--caret {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .nav-link:hover,
        .nav-link:focus-visible {
            color: var(--nav-accent);
            background: rgba(26, 86, 219, 0.08);
        }
        .nav-link--active {
            color: var(--nav-accent);
            background: rgba(16, 185, 129, 0.12);
        }
        .nav-item {
            position: relative;
        }
        .nav-caret {
            margin-left: 0;
            width: 0.8rem;
            height: 0.8rem;
            display: block;
        }
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 0.6rem);
            left: 50%;
            transform: translateX(-50%) translateY(8px);
            min-width: 220px;
            background: #f1f5f9;
            color: #0f172a;
            border-radius: 0.9rem;
            padding: 0.6rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s ease;
            z-index: 30;
        }
        .dropdown-menu a {
            display: block;
            padding: 0.55rem 0.75rem;
            border-radius: 0.6rem;
            font-size: 0.9rem;
            color: inherit;
            transition: background 0.2s ease;
        }
        .dropdown-menu a:hover {
            background: rgba(15, 23, 42, 0.06);
        }
        .nav-item:hover .dropdown-menu,
        .nav-item:focus-within .dropdown-menu {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(-50%) translateY(0);
        }
        .nav-user {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .nav-user-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--nav-text);
        }
        .nav-user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            background: #0f172a;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .mobile-menu {
            border-top: 1px solid var(--nav-border);
            background: #ffffff;
            padding: 0.75rem 1rem 1rem;
        }
        .mobile-menu a,
        .mobile-menu button,
        .mobile-menu summary {
            color: #475569;
            font-weight: 600;
        }
        .mobile-menu details {
            border-radius: 0.75rem;
            background: #f8fafc;
            padding: 0.6rem 0.8rem;
        }
        .mobile-menu details[open] summary {
            color: var(--nav-accent);
        }
        .mobile-sub a {
            display: block;
            padding: 0.4rem 0.5rem 0.4rem 1rem;
            font-size: 0.9rem;
            color: #64748b;
        }
        .hero-pattern {
            background-color: #1e293b;
            position: relative;
            overflow: hidden;
        }
        .hero-pattern::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        .smooth-scroll { scroll-behavior: smooth; }
    </style>
    @stack('styles')
</head>
<body class="smooth-scroll bg-gray-50">

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar">
        <div class="navbar-inner">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="brand">
                <div class="brand-badge">SD</div>
                <div>
                    <h1 class="brand-title">SD N 2 Dermolo</h1>
                    <p class="brand-sub">Unggul & Berkarakter</p>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex nav-group">
                <a href="{{ route('home') }}#home" class="nav-link nav-link--active">Beranda</a>
                <div class="nav-item">
                    <button class="nav-link nav-link--caret" type="button">
                        Profil
                        <svg class="nav-caret" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('home') }}#tentang">Identitas Sekolah</a>
                        <a href="{{ route('fasilitas.index') }}">Sarana Prasarana</a>
                        <a href="{{ route('program.index') }}">Ekstrakurikuler</a>
                    </div>
                </div>
                <a href="{{ route('guru.index') }}" class="nav-link">Data Guru</a>
                <a href="{{ route('news.index') }}" class="nav-link">Berita</a>
                <a href="{{ route('prestasi.index') }}" class="nav-link">Prestasi</a>
                <a href="{{ route('home') }}#kontak" class="nav-link">Kontak</a>
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-600 hover:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Menu Mobile --}}
        <div id="mobile-menu" class="hidden md:hidden mobile-menu space-y-3">
            <a href="{{ route('home') }}#home" class="block py-2">Beranda</a>
            <details>
                <summary class="cursor-pointer">Profil</summary>
                <div class="mobile-sub mt-2">
                    <a href="{{ route('home') }}#tentang">Identitas Sekolah</a>
                    <a href="{{ route('fasilitas.index') }}">Sarana Prasarana</a>
                    <a href="{{ route('program.index') }}">Ekstrakurikuler</a>
                </div>
            </details>
            <a href="{{ route('guru.index') }}" class="block py-2">Data Guru</a>
            <a href="{{ route('news.index') }}" class="block py-2">Berita</a>
            <a href="{{ route('prestasi.index') }}" class="block py-2">Prestasi</a>
            <a href="{{ route('home') }}#kontak" class="block py-2">Kontak</a>
        </div>
    </nav>

    {{-- ===== KONTEN HALAMAN ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8 mb-8">

                {{-- Kolom 1: Info Sekolah --}}
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-md mr-3">
                            <span class="text-white font-bold">SD</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">SD N 2 Dermolo</h3>
                            <p class="text-gray-400 text-xs">Unggul & Berkarakter</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Sekolah Dasar Negeri 2 Dermolo berkomitmen memberikan pendidikan berkualitas tinggi bagi generasi muda Indonesia.
                    </p>
                </div>

                {{-- Kolom 2: Tautan Cepat --}}
                <div>
                    <h4 class="font-bold text-lg mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}"                         class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('home') }}#tentang"                class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('program.index') }}"               class="hover:text-white transition">Program</a></li>
                        <li><a href="{{ route('prestasi.index') }}"              class="hover:text-white transition">Prestasi</a></li>
                        <li><a href="{{ route('fasilitas.index') }}"             class="hover:text-white transition">Fasilitas</a></li>
                        <li><a href="{{ route('guru.index') }}"                  class="hover:text-white transition">Guru Pendidik</a></li>
                        <li><a href="{{ route('news.index') }}"                  class="hover:text-white transition">Berita</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Kontak --}}
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li class="flex items-center gap-2"><span>📍</span> Desa Dermolo, Jepara, Jawa Tengah</li>
                        <li class="flex items-center gap-2"><span>📞</span> (0291) 123-456</li>
                        <li class="flex items-center gap-2"><span>✉️</span> sdn2dermolo@gmail.com</li>
                    </ul>
                </div>

            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} SD N 2 Dermolo. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <div id="public-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60" data-confirm-close="true"></div>
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <h3 class="text-lg font-semibold text-slate-900">Konfirmasi</h3>
            <p id="public-confirm-message" class="mt-2 text-sm text-slate-600">Apakah Anda yakin?</p>
            <div class="mt-6 flex items-center justify-end gap-2">
                <button type="button" id="public-confirm-cancel"
                        class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="button" id="public-confirm-ok"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Lanjutkan
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
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

                // Avatar dropdown
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', (event) => {
                event.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', (event) => {
                if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }

        // Konfirmasi aksi (logout)
        const publicModal = document.getElementById('public-confirm-modal');
        const publicMessage = document.getElementById('public-confirm-message');
        const publicOk = document.getElementById('public-confirm-ok');
        const publicCancel = document.getElementById('public-confirm-cancel');
        let pendingPublicForm = null;

        document.querySelectorAll('form[data-confirm]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                pendingPublicForm = form;
                publicMessage.textContent = form.dataset.confirm || 'Apakah Anda yakin?';
                publicModal.classList.remove('hidden');
                publicModal.classList.add('flex');
            });
        });

        const closePublicModal = () => {
            pendingPublicForm = null;
            publicModal.classList.add('hidden');
            publicModal.classList.remove('flex');
        };

        publicCancel?.addEventListener('click', closePublicModal);
        publicModal?.addEventListener('click', (event) => {
            if (event.target?.dataset?.confirmClose) {
                closePublicModal();
            }
        });
        publicOk?.addEventListener('click', () => {
            if (pendingPublicForm) {
                pendingPublicForm.submit();
            }
            closePublicModal();
        });
// Scroll to top — tampilkan tombol setelah scroll 300px
        const scrollToTopBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            scrollToTopBtn.classList.toggle('hidden', window.pageYOffset <= 300);
        });
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Animasi card muncul saat di-scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.card-hover').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>

    @stack('scripts')
</body>
</html>

