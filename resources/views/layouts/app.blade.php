<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SD N 2 Dermolo')</title>
    @if (trim($__env->yieldContent('meta_description')))
        <meta name="description" content="@yield('meta_description')">
    @endif
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
        .nav-link           { position: relative; transition: color 0.3s ease; }
        .nav-link::after    { content: ''; position: absolute; width: 0; height: 2px; bottom: -5px; left: 0; background-color: #fbbf24; transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
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
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 h-20 flex justify-between items-center">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-md">
                    <span class="text-white font-bold">SD</span>
                </div>
                <div class="ml-4 text-gray-800">
                    <h1 class="font-bold text-lg leading-none">SD N 2 Dermolo</h1>
                    <p class="text-[10px] uppercase tracking-widest text-gray-500">Unggul & Berkarakter</p>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex space-x-8 text-gray-600 font-medium">
                <a href="{{ route('home') }}#home"      class="nav-link hover:text-blue-600 transition-colors">Beranda</a>
                <a href="{{ route('home') }}#tentang"   class="nav-link hover:text-blue-600 transition-colors">Tentang</a>
                <a href="{{ route('program.index') }}" class="nav-link hover:text-blue-600 transition-colors">Program</a>
                <a href="{{ route('prestasi.index') }}" class="nav-link hover:text-blue-600 transition-colors">Prestasi</a>
                <a href="{{ route('fasilitas.index') }}" class="nav-link hover:text-blue-600 transition-colors">Fasilitas</a>
                <a href="{{ route('guru.index') }}" class="nav-link hover:text-blue-600 transition-colors">Guru Pendidik</a>
                <a href="{{ route('news.index') }}" class="nav-link hover:text-blue-600 transition-colors">Berita</a>
                <a href="{{ route('home') }}#kontak"    class="nav-link hover:text-blue-600 transition-colors">Kontak</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-link hover:text-blue-600 transition-colors">Admin</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="nav-link hover:text-blue-600 transition-colors">Logout</button>
                    </form>
                @endauth
            </div>

            {{-- Tombol Hamburger (Mobile) --}}
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-600 hover:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Menu Mobile --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t px-4 py-3 space-y-2">
            <a href="{{ route('home') }}#home"      class="block text-gray-600 hover:text-blue-600 py-2">Beranda</a>
            <a href="{{ route('home') }}#tentang"   class="block text-gray-600 hover:text-blue-600 py-2">Tentang</a>
            <a href="{{ route('program.index') }}" class="block text-gray-600 hover:text-blue-600 py-2">Program</a>
            <a href="{{ route('prestasi.index') }}" class="block text-gray-600 hover:text-blue-600 py-2">Prestasi</a>
            <a href="{{ route('fasilitas.index') }}" class="block text-gray-600 hover:text-blue-600 py-2">Fasilitas</a>
            <a href="{{ route('guru.index') }}" class="block text-gray-600 hover:text-blue-600 py-2">Guru Pendidik</a>
            <a href="{{ route('news.index') }}" class="block text-gray-600 hover:text-blue-600 py-2">Berita</a>
            <a href="{{ route('home') }}#kontak"    class="block text-gray-600 hover:text-blue-600 py-2">Kontak</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="block text-gray-600 hover:text-blue-600 py-2">Admin</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block text-gray-600 hover:text-blue-600 py-2">Logout</button>
                </form>
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
