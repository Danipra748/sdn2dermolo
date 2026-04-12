@extends('admin.layout')

@section('title', 'Kelola Gambar Hero Section')
@section('heading', 'Kelola Gambar Hero Section')

@section('content')
    <div class="max-w-4xl">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Current Hero Image Display --}}
        <div class="glass rounded-3xl p-6 mb-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-2">Gambar Hero Section Saat Ini</h2>
            <p class="text-sm text-slate-500 mb-6">Gambar ini akan ditampilkan sebagai background di halaman beranda</p>

            @if($heroImage)
                <div class="relative rounded-2xl overflow-hidden border border-slate-200 mb-6">
                    <img src="{{ asset('storage/' . $heroImage) }}" 
                         alt="Hero Background" 
                         class="w-full h-80 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between">
                        <div class="text-white">
                            <p class="text-sm font-semibold">Preview Hero Section</p>
                            <p class="text-xs text-white/80">Gambar background yang aktif saat ini</p>
                        </div>
                    </div>
                </div>

                {{-- Delete Button --}}
                <form action="{{ route('admin.hero-image.destroy') }}" 
                      method="POST" 
                      class="inline-block"
                      data-confirm="Yakin ingin menghapus gambar hero section?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Gambar
                    </button>
                </form>
            @else
                <div class="w-full h-64 rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center mb-6">
                    <div class="text-center text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm">Belum ada gambar hero section</p>
                        <p class="text-xs mt-1">Gradient biru akan ditampilkan sebagai fallback</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Upload Form --}}
        <div class="glass rounded-3xl p-6 mb-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-2">Unggah Gambar Baru</h2>
            <p class="text-sm text-slate-500 mb-6">Pilih gambar yang akan digunakan sebagai background hero section</p>

            <form action="{{ route('admin.hero-image.update') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Pilih Gambar
                    </label>
                    <input type="file" 
                           name="hero_image" 
                           id="hero-image-input"
                           accept="image/jpeg,image/jpg,image/png,image/webp"
                           class="drop-zone-enabled block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100"
                           required>
                    <p class="mt-2 text-xs text-slate-500">
                        Format yang didukung: JPG, PNG, WebP (Maks. 2MB)
                    </p>
                    <p class="text-xs text-slate-500">
                        Rekomendasi: Gambar dengan resolusi minimal 1920x1080 piksel untuk hasil terbaik
                    </p>
                </div>

                {{-- Preview --}}
                <div id="image-preview-container" class="mb-6 hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Preview Gambar
                    </label>
                    <div class="relative rounded-xl overflow-hidden border border-slate-200">
                        <img id="image-preview" src="" alt="Preview" class="w-full h-64 object-cover">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Unggah & Aktifkan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Information Card --}}
        <div class="rounded-2xl bg-blue-50 border border-blue-200 p-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-2">Panduan Gambar Hero Section</h3>
                    <ul class="text-sm text-blue-700 space-y-1.5">
                        <li>Gambar akan ditampilkan sebagai background full-screen di halaman beranda</li>
                        <li>Gunakan gambar dengan resolusi tinggi (minimal 1920x1080 piksel)</li>
                        <li>Format yang didukung: JPG, PNG, dan WebP</li>
                        <li>Ukuran file maksimal: 2MB</li>
                        <li>Gambar akan otomatis di-crop dan disesuaikan dengan rasio layar</li>
                        <li>Jika tidak ada gambar, gradient biru akan ditampilkan sebagai fallback</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Image preview
        const imageInput = document.getElementById('hero-image-input');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
    @endpush
@endsection
