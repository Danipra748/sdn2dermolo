@extends('admin.layout')

@section('title', 'Upload Logo Sekolah')
@section('heading', 'Upload Logo Sekolah')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="glass rounded-3xl p-6">
            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-2"><i class="fas fa-camera"></i> Upload Logo Sekolah</h3>
                <p class="text-sm text-slate-500">Upload logo SD Negeri 2 Dermolo untuk ditampilkan di admin dashboard dan halaman publik.</p>
            </div>

            {{-- Current Logo Preview --}}
            <div class="mb-6 p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                <p class="text-sm font-semibold text-slate-700 mb-4">Logo Saat Ini:</p>
                @php
                    $logoPath = storage_path('app/public/logos/sd-negeri-2-dermolo.png');
                    $logoExists = file_exists($logoPath);
                @endphp
                
                @if($logoExists)
                    <img src="{{ asset('storage/logos/sd-negeri-2-dermolo.png') }}"
                         alt="Logo SD N 2 Dermolo"
                         class="w-48 h-48 mx-auto object-contain bg-white p-4 rounded-2xl shadow-lg">
                    <p class="text-xs text-green-600 mt-4">Logo berhasil ditampilkan</p>
                @else
                    <div class="w-48 h-48 mx-auto bg-slate-200 rounded-2xl flex items-center justify-center text-slate-400">
                        <div class="text-center">
                            <i class="fas fa-school text-4xl mb-2"></i>
                            <p class="text-xs">Belum ada logo</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-4">Upload logo untuk menampilkan di dashboard</p>
                @endif
            </div>

            {{-- Upload Form --}}
            <form action="{{ route('admin.settings.upload-logo') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Upload Logo Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                           name="logo" 
                           id="logo-input"
                           accept=".png,.jpg,.jpeg,.webp,.svg"
                           required
                           onchange="previewLogo(event)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    
                    <p class="text-xs text-slate-500 mt-2">
                        <i class="fas fa-camera"></i> Format: PNG, JPG, JPEG, WEBP, SVG | Maksimal: 5MB
                    </p>
                    @error('logo')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preview Logo Baru --}}
                <div id="new-logo-preview" class="hidden">
                    <p class="text-sm font-semibold text-slate-700 mb-3">Preview Logo Baru:</p>
                    <div class="p-6 rounded-2xl bg-blue-50 border border-blue-200 text-center">
                        <img id="preview-img" 
                             src="" 
                             alt="Preview Logo"
                             class="w-48 h-48 mx-auto object-contain bg-white p-4 rounded-2xl shadow-lg">
                        <p class="text-xs text-blue-600 mt-4">✓ Logo siap diupload</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                            class="flex-1 px-6 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition shadow-lg">
                        <i class="fas fa-upload"></i> Upload Logo
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>

            {{-- Info Card --}}
            <div class="mt-6 rounded-2xl bg-blue-50 border border-blue-200 p-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-blue-900 mb-1">Informasi</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Logo akan ditampilkan di sidebar admin dashboard</li>
                            <li>• Logo otomatis muncul di halaman publik (header)</li>
                            <li>• Format PNG dengan background transparan direkomendasikan</li>
                            <li>• Ukuran ideal: 500x500 pixels</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Preview logo sebelum upload
    function previewLogo(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validasi ukuran (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('new-logo-preview');
            const previewImg = document.getElementById('preview-img');
            
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            
            console.log('Logo preview loaded:', file.name, Math.round(file.size / 1024) + 'KB');
        };
        reader.readAsDataURL(file);
    }
</script>
@endpush
