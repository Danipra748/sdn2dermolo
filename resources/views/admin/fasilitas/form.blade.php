@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="glass rounded-3xl p-6">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if ($method !== 'POST')
                    @method($method)
                @endif

                {{-- Nama Fasilitas --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Fasilitas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           value="{{ old('nama', $fasilitas->nama) }}"
                           placeholder="Contoh: Ruang Kelas, Perpustakaan, Musholla"
                           required
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    @error('nama')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="deskripsi" 
                              rows="4"
                              placeholder="Deskripsi singkat tentang fasilitas ini (tidak wajib diisi)"
                              class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                    <p class="text-xs text-slate-500 mt-2">
                        ℹ️ Deskripsi akan tampil sebagai subtitle di halaman publik. Bisa dikosongkan.
                    </p>
                    @error('deskripsi')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Gambar Fasilitas --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Foto Fasilitas
                    </label>
                    
                    {{-- Preview gambar saat ini --}}
                    @if ($fasilitas->foto)
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-2">Foto saat ini:</p>
                            <div class="relative inline-block">
                                <img id="current-image-preview" 
                                     src="{{ asset('storage/' . $fasilitas->foto) }}" 
                                     alt="Foto {{ $fasilitas->nama }}"
                                     class="w-full max-w-md h-48 object-cover rounded-xl border border-slate-200">
                                <label class="absolute top-2 right-2 inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-500 text-white text-xs font-semibold cursor-pointer hover:bg-red-600 transition shadow-lg">
                                    <input type="checkbox" name="remove_foto" value="1" id="remove-foto"
                                           class="hidden"
                                           onchange="toggleRemoveFoto()">
                                    <span id="remove-foto-label">Hapus foto</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    {{-- Upload input --}}
                    <div class="relative">
                        <input type="file" 
                               name="foto" 
                               id="foto-input"
                               accept=".jpg,.jpeg,.png,.webp"
                               onchange="previewImage(event)"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        
                        <p class="text-xs text-slate-500 mt-2">
                            📸 Format: JPG, JPEG, PNG, WEBP | Maksimal: 2MB
                        </p>
                        @error('foto')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview gambar baru yang akan diupload --}}
                    <div id="new-image-preview" class="mt-4 hidden">
                        <p class="text-xs text-slate-500 mb-2">Preview foto baru:</p>
                        <img id="preview-img" 
                             src="" 
                             alt="Preview"
                             class="w-full max-w-md h-48 object-cover rounded-xl border-2 border-blue-500 shadow-lg">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                            class="flex-1 px-6 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition shadow-lg">
                        {{ $method === 'PUT' ? '💾 Update' : '✨ Simpan' }}
                    </button>
                    <a href="{{ route('admin.fasilitas.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Preview image sebelum upload
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validasi ukuran (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('❌ Ukuran file terlalu besar! Maksimal 2MB.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('new-image-preview');
            const previewImg = document.getElementById('preview-img');
            
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            
            console.log('📸 Image preview loaded:', file.name, Math.round(file.size / 1024) + 'KB');
        };
        reader.readAsDataURL(file);
    }

    // Toggle remove foto
    function toggleRemoveFoto() {
        const checkbox = document.getElementById('remove-foto');
        const label = document.getElementById('remove-foto-label');
        const currentPreview = document.getElementById('current-image-preview');
        
        if (checkbox.checked) {
            label.textContent = '✓ Akan dihapus';
            currentPreview.style.opacity = '0.4';
        } else {
            label.textContent = 'Hapus foto';
            currentPreview.style.opacity = '1';
        }
    }
</script>
@endpush
