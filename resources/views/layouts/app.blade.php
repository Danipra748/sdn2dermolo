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
        /* Card hover effects */
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .teacher-card { transition: all 0.3s ease; }
        .teacher-card:hover { transform: scale(1.05); }
    </style>
    @stack('styles')
</head>
<body class="scroll-smooth bg-gray-50">

    {{-- ===== NAVBAR ===== --}}
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-gradient-to-b from-slate-50 to-white shadow-[0_10px_30px_rgba(15,23,42,0.08)]">
        <div class="mx-auto grid h-[76px] max-w-6xl grid-cols-[auto,1fr,auto] items-center gap-6 px-4 lg:px-14">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-500 text-sm font-extrabold text-white shadow-[0_8px_20px_rgba(26,86,219,0.25)]">SD</div>
                <div>
                    <h1 class="text-base font-extrabold leading-tight text-slate-900">SD N 2 Dermolo</h1>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Unggul & Berkarakter</p>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center justify-center gap-5 font-semibold text-slate-500 md:ml-8">
                <a href="{{ route('home') }}#home" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('home') && !request()->filled('section') ? 'bg-emerald-50 text-blue-600' : '' }}">Beranda</a>
                
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
                        <a href="{{ route('home') }}#tentang" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition">Identitas Sekolah</a>
                        <a href="{{ route('fasilitas.index') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('fasilitas.*') ? 'bg-blue-50 text-blue-600' : '' }}">Sarana Prasarana</a>
                        <a href="{{ route('program.index') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('program.*') ? 'bg-blue-50 text-blue-600' : '' }}">Ekstrakurikuler</a>
                    </div>
                </div>
                
                <a href="{{ route('guru.index') }}" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('guru.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Data Guru</a>
                <a href="{{ route('news.index') }}" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('news.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Berita</a>
                <a href="{{ route('prestasi.index') }}" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('prestasi.*') ? 'bg-emerald-50 text-blue-600' : '' }}">Prestasi</a>
                <a href="{{ route('home') }}#kontak" class="rounded-full px-3 py-2 text-sm transition hover:bg-blue-50 hover:text-blue-600">Kontak</a>
            </div>

            {{-- Right Side Actions --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- User Avatar/Logout --}}
                    <div class="relative group">
                        <button class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-blue-500 text-white font-bold flex items-center justify-center shadow-md hover:shadow-lg transition">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </button>
                        {{-- Dropdown Menu --}}
                        <div class="absolute right-0 top-full mt-2 w-48 rounded-xl bg-white p-2 text-slate-900 shadow-[0_16px_40px_rgba(15,23,42,0.12)] border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 translate-y-2 group-hover:translate-y-0">
                            <div class="px-3 py-2 border-b border-slate-100">
                                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Dashboard Admin
                            </a>
                            <form action="{{ route('logout') }}" method="POST" data-confirm="Yakin ingin logout?">
                                @csrf
                                <button type="submit" class="w-full text-left rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <button id="mobile-menu-button" class="md:hidden rounded-md p-2 text-slate-600 hover:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Menu Mobile --}}
        <div id="mobile-menu" class="hidden md:hidden space-y-3 border-t border-slate-200 bg-white px-4 pb-4 pt-3">
            <a href="{{ route('home') }}#home" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">Beranda</a>
            <details class="rounded-xl bg-slate-50 px-3 py-2">
                <summary class="cursor-pointer font-semibold text-slate-600">Profil</summary>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('home') }}#tentang" class="block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500">Identitas Sekolah</a>
                    <a href="{{ route('fasilitas.index') }}" class="block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500">Sarana Prasarana</a>
                    <a href="{{ route('program.index') }}" class="block rounded-lg px-3 py-1.5 text-sm font-medium text-slate-500">Ekstrakurikuler</a>
                </div>
            </details>
            <a href="{{ route('guru.index') }}" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('guru.*') ? 'text-blue-600' : '' }}">Data Guru</a>
            <a href="{{ route('news.index') }}" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('news.*') ? 'text-blue-600' : '' }}">Berita</a>
            <a href="{{ route('prestasi.index') }}" class="block py-2 font-semibold text-slate-600 {{ request()->routeIs('prestasi.*') ? 'text-blue-600' : '' }}">Prestasi</a>
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
                        @guest
                            <li class="pt-2 mt-2 border-t border-gray-700">
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-blue-400 hover:text-blue-300 transition font-semibold">
                                    <x-heroicon-o-lock-closed class="w-4 h-4" />
                                    Login Admin
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>

                {{-- Kolom 3: Kontak --}}
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="w-4 h-4 text-slate-300" />
                            Desa Dermolo, Jepara, Jawa Tengah
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-phone class="w-4 h-4 text-slate-300" />
                            (0291) 123-456
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-envelope class="w-4 h-4 text-slate-300" />
                            sdn2dermolo@gmail.com
                        </li>
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
