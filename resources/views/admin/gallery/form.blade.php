@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="glass rounded-3xl p-6 max-w-2xl">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="gallery-form">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            {{-- Judul Foto --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-slate-700">
                    Judul Foto
                </label>
                <input type="text" 
                       name="judul" 
                       value="{{ old('judul', $gallery->judul) }}"
                       placeholder="Contoh: Kegiatan Upacara Bendera 2024"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-cyan focus:border-cyan transition">
                @error('judul')
                    <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Deskripsi (Opsional) --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-slate-700">
                    Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
                </label>
                <textarea name="deskripsi" 
                          rows="4"
                          placeholder="Ceritakan detail kegiatan atau momen foto ini (tidak wajib diisi)"
                          class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-cyan focus:border-cyan transition resize-none">{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">
                    <i class="fas fa-lightbulb text-yellow-500"></i> Isi deskripsi untuk memberikan konteks tentang foto ini. Bisa dikosongkan jika hanya ingin menampilkan judul dan foto.
                </p>
                @error('deskripsi')
                    <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Foto dengan Drag & Drop --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700">
                    Foto <span class="text-red-500">*</span>
                </label>
                
                {{-- Drop Zone Container --}}
                <div id="gallery-drop-zone" 
                     class="relative border-2 border-dashed border-slate-300 rounded-xl p-6 text-center transition-all duration-300 bg-slate-50 hover:border-cyan hover:bg-cyan-50 cursor-pointer"
                     onclick="document.getElementById('foto-input').click()">
                    
                    {{-- Default Content (Before Upload) --}}
                    <div id="drop-zone-content" class="pointer-events-none">
                        <svg class="mx-auto h-16 w-16 text-slate-400 mb-3 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm font-medium text-slate-700 mb-1">
                            Seret foto ke sini atau klik untuk memilih
                        </p>
                        <p class="text-xs text-slate-500">
                            Format: JPG, JPEG, PNG, WEBP (Maks. 2MB)
                        </p>
                    </div>

                    {{-- Preview Container (After Upload) --}}
                    <div id="gallery-preview" class="hidden">
                        <img id="preview-image" 
                             src="" 
                             alt="Preview" 
                             class="mx-auto max-h-64 rounded-xl object-cover shadow-sm mb-3">
                        <div class="bg-white rounded-lg px-4 py-3 border border-slate-200">
                            <p class="text-xs text-slate-600 mb-1">
                                <span class="font-medium">Nama File:</span> 
                                <span id="file-name" class="text-slate-800">-</span>
                            </p>
                            <p class="text-xs text-slate-500">
                                <span class="font-medium">Ukuran:</span> 
                                <span id="file-size" class="text-slate-700">-</span>
                            </p>
                        </div>
                        <button type="button" 
                                onclick="event.stopPropagation(); removeGalleryFile();" 
                                class="mt-3 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                            <svg class="inline-block w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Hapus Foto
                        </button>
                    </div>

                    {{-- Hidden File Input --}}
                    <input type="file"
                           id="foto-input"
                           name="foto"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="hidden"
                           {{ $method === 'POST' ? 'required' : '' }}>
                </div>

                {{-- Error Message --}}
                <div id="gallery-error" class="hidden text-xs text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                </div>

                {{-- Validation Error from Laravel --}}
                @error('foto')
                    <p class="text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                {{-- Existing Photo (Edit Mode) --}}
                @if ($gallery->foto)
                    <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <p class="text-xs text-slate-600 mb-2 font-medium">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $gallery->foto) }}" 
                             alt="{{ $gallery->judul }}"
                             class="h-24 w-full max-w-xs rounded-xl object-cover border border-slate-300">
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <button type="submit"
                        class="flex-1 px-6 py-3 rounded-xl bg-cyan hover:bg-cyan-dark text-white text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.gallery.index') }}"
                   class="px-6 py-3 rounded-xl border-2 border-slate-300 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-400 transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Drop Zone Configuration
    const dropZone = document.getElementById('gallery-drop-zone');
    const fileInput = document.getElementById('foto-input');
    const dropZoneContent = document.getElementById('drop-zone-content');
    const galleryPreview = document.getElementById('gallery-preview');
    const previewImage = document.getElementById('preview-image');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const galleryError = document.getElementById('gallery-error');

    // Configuration
    const config = {
        acceptedTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
        maxSize: 2 * 1024 * 1024, // 2MB
        acceptedExtensions: '.jpg, .jpeg, .png, .webp',
        maxSizeDisplay: '2MB'
    };

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Validate file
    function validateFile(file) {
        if (!config.acceptedTypes.includes(file.type)) {
            return {
                valid: false,
                message: 'Format file tidak didukung. Gunakan: ' + config.acceptedExtensions
            };
        }

        if (file.size > config.maxSize) {
            return {
                valid: false,
                message: 'Ukuran file terlalu besar. Maksimal ' + config.maxSizeDisplay
            };
        }

        return { valid: true };
    }

    // Show error
    function showError(message) {
        galleryError.textContent = message;
        galleryError.classList.remove('hidden');
        
        setTimeout(() => {
            galleryError.classList.add('hidden');
        }, 5000);
    }

    // Hide error
    function hideError() {
        galleryError.classList.add('hidden');
    }

    // Handle file selection
    function handleFile(file) {
        const validation = validateFile(file);

        if (!validation.valid) {
            showError(validation.message);
            return false;
        }

        hideError();

        // Set file to input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        // Trigger change event
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);

        // Show preview for images
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                galleryPreview.classList.remove('hidden');
                dropZoneContent.classList.add('hidden');
                dropZone.classList.add('border-green-500', 'bg-green-50');
                dropZone.classList.remove('border-slate-300', 'bg-slate-50');
            };
            reader.readAsDataURL(file);
        }

        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        return true;
    }

    // Remove file
    window.removeGalleryFile = function() {
        fileInput.value = '';
        previewImage.src = '';
        galleryPreview.classList.add('hidden');
        dropZoneContent.classList.remove('hidden');
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        dropZone.classList.add('border-slate-300', 'bg-slate-50');
        hideError();
    };

    // Prevent default drag behavior
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Highlight on drag over
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-green-500', 'bg-green-100');
            dropZone.classList.remove('border-slate-300', 'bg-slate-50', 'border-cyan', 'bg-cyan-50');
        });
    });

    // Unhighlight on drag leave/drop
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            if (!fileInput.files.length) {
                dropZone.classList.remove('border-green-500', 'bg-green-100');
                dropZone.classList.add('border-slate-300', 'bg-slate-50');
            } else {
                dropZone.classList.remove('border-green-500', 'bg-green-100');
            }
        });
    });

    // Handle drop
    dropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // Handle file input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    // Form validation before submit
    const form = document.getElementById('gallery-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const isRequired = {{ $method === 'POST' ? 'true' : 'false' }};
            
            if (isRequired && fileInput.files.length === 0) {
                e.preventDefault();
                showError('Silakan pilih foto terlebih dahulu.');
                return false;
            }
        });
    }

    console.log('[Gallery Form] Drop zone initialized successfully');
});
</script>
@endpush

