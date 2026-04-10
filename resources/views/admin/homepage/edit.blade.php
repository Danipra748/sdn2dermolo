@extends('admin.layout')

@section('title', 'Edit Hero Section')
@section('heading', 'Edit Hero Section')

@section('content')
    <div class="max-w-6xl">
        <form action="{{ route('admin.homepage.update', $section->section_key) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="glass rounded-3xl p-6">
            @csrf
            @method('PUT')

            {{-- Section Info --}}
            <div class="mb-6 pb-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">{{ $section->section_name }}</h3>
                <p class="text-sm text-slate-500 mt-1">Key: <code>{{ $section->section_key }}</code></p>
            </div>

            {{-- Title & Subtitle --}}
            <div class="grid md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul</label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $section->title) }}"
                           placeholder="Contoh: SD N 2 Dermolo"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Subtitle</label>
                    <input type="text" 
                           name="subtitle" 
                           value="{{ old('subtitle', $section->subtitle) }}"
                           placeholder="Contoh: Unggul & Berkarakter"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('subtitle')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                <textarea name="description"
                          rows="3"
                          placeholder="Deskripsi section..."
                          class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('description', $section->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Per-Slide Text Content --}}
            <div class="mb-5 p-5 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <label class="block text-base font-semibold text-slate-900">📝 Teks Tiap Slide</label>
                        <p class="text-xs text-slate-600 mt-1">Atur judul dan subjudul yang berbeda untuk setiap gambar slider</p>
                    </div>
                    <button type="button"
                            onclick="addNewSlide()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Slide
                    </button>
                </div>

                <div id="slide-texts-container" class="space-y-4">
                    {{-- Slide text fields will be rendered here by JavaScript --}}
                </div>

                <input type="hidden" name="slide_texts_json" id="slide-texts-json"
                       value="{{ old('slide_texts_json', json_encode($section->extra_data['slide_texts'] ?? [])) }}">
            </div>

            {{-- Preview Section --}}
            <div class="mb-5 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <label class="block text-sm font-medium text-slate-700 mb-3">Preview Background</label>
                @if($section->background_image)
                    <div class="relative rounded-xl overflow-hidden border border-slate-200">
                        <img id="hero-preview-img"
                             src="{{ asset('storage/' . $section->background_image) }}"
                             alt="Hero Background"
                             class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-slate-900"
                             style="opacity: {{ $section->background_overlay_opacity ?? 0.35 }};">
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white">
                                <p class="text-2xl font-bold">{{ $section->title ?? 'SD N 2 Dermolo' }}</p>
                                <p class="text-lg mt-2">{{ $section->subtitle ?? 'Unggul & Berkarakter' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="hero-preview-placeholder" class="w-full h-64 bg-slate-100 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                        <div class="text-center">
                            <p class="text-sm">Belum ada background image</p>
                            <p class="text-xs mt-1">Upload dan pilih gambar di Media Library</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Media Library Section --}}
            <div class="mb-5">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">📸 Media Library</label>
                        <p class="text-xs text-slate-500 mt-1">Pilih gambar untuk slideshow. Klik gambar untuk select/unselect.</p>
                    </div>
                    <button type="button"
                            onclick="document.getElementById('upload-media-input').click()"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                        <x-heroicon-o-cloud-arrow-up class="w-4 h-4" />
                        Upload New
                    </button>
                    <input type="file"
                           id="upload-media-input"
                           accept="image/*"
                           multiple
                           class="hidden"
                           onchange="handleUpload(this)">
                </div>

                {{-- Hidden input untuk menyimpan selected images ke form --}}
                <input type="hidden" name="selected_images_json" id="selected-images-json" value="{{ old('selected_images_json', json_encode($section->extra_data['slideshow_images'] ?? [])) }}">
                <input type="hidden" name="background_image_primary" id="background-image-primary" value="{{ old('background_image_primary', $section->background_image) }}">

                {{-- Selected Images for Slideshow --}}
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-semibold text-slate-700">
                            ✅ Selected for Slideshow (<span id="selected-count">0</span>)
                        </h4>
                        <p class="text-xs text-slate-500">First image = Primary</p>
                    </div>
                    <div id="selected-images" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200 min-h-[120px]">
                        <p class="text-sm text-slate-400 col-span-full text-center py-8">No images selected yet</p>
                    </div>
                </div>

                {{-- All Media Library --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-semibold text-slate-700">
                            📁 Media Library (<span id="library-count">0</span>)
                        </h4>
                        <button type="button"
                                onclick="selectAllImages()"
                                class="text-xs text-blue-600 hover:text-blue-800 font-semibold">
                            Select All
                        </button>
                    </div>
                    <div id="media-library" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 p-4 rounded-xl bg-white border border-slate-200 min-h-[200px]">
                        <p class="text-sm text-slate-400 col-span-full text-center py-8">Loading media library...</p>
                    </div>
                </div>
            </div>

            {{-- Overlay Opacity --}}
            @if($section->section_key === 'hero')
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Overlay Opacity ({{ round($section->background_overlay_opacity * 100) }}%)
                </label>
                <input type="range" 
                       name="background_overlay_opacity" 
                       min="0" 
                       max="1" 
                       step="0.05"
                       value="{{ old('background_overlay_opacity', $section->background_overlay_opacity) }}"
                       class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer"
                       id="opacity-range">
                <div class="mt-2 flex justify-between text-xs text-slate-500">
                    <span>Terang (0%)</span>
                    <span>Gelap (100%)</span>
                </div>
            </div>
            @endif

            {{-- Extra Data (JSON) --}}
            @if($section->extra_data)
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Extra Data (Advanced)
                </label>
                <textarea name="extra_data" 
                          rows="4"
                          class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('extra_data', json_encode($section->extra_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Format JSON. Biarkan default jika tidak yakin.</p>
                @error('extra_data')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.homepage.index') }}"
                   class="px-6 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    const sectionKey = '{{ $section->section_key }}';
    const csrfToken = '{{ csrf_token() }}';
    
    // State
    let allImages = [];
    let selectedImages = [];
    let isSubmittingForm = false;

    // Show notification toast
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-xl shadow-lg z-50 text-white font-semibold transition-all duration-300 transform translate-x-0 ${
            type === 'success' ? 'bg-green-600' : 'bg-red-600'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Homepage editor initialized');
        
        loadMediaLibrary();

        // Sync hidden inputs on load
        syncHiddenInputs();

        // Form submit handler - sekarang form akan submit normally dengan hidden inputs
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('📤 Form submit triggered');
                
                // Update hidden inputs sebelum submit
                syncHiddenInputs();
                
                // Log what will be submitted
                const formData = new FormData(form);
                console.log('📦 Form data to be submitted:', {
                    title: formData.get('title'),
                    subtitle: formData.get('subtitle'),
                    background_image_primary: formData.get('background_image_primary'),
                    selected_images_json: formData.get('selected_images_json'),
                    background_overlay_opacity: formData.get('background_overlay_opacity'),
                });
                
                // Show loading
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = '⏳ Menyimpan...';
                }
                
                console.log('✅ Allowing form to submit normally...');
                // Biarkan form submit normally dengan data dari hidden inputs
                // Form akan POST ke route('admin.homepage.update') dengan semua data
            });
        }
    });

    // Sync selected images ke hidden inputs
    function syncHiddenInputs() {
        const primaryInput = document.getElementById('background-image-primary');
        const slideshowInput = document.getElementById('selected-images-json');

        if (primaryInput && slideshowInput) {
            const primaryValue = selectedImages[0] || '';
            const slideshowValue = JSON.stringify(selectedImages.slice(1) || []);
            
            primaryInput.value = primaryValue;
            slideshowInput.value = slideshowValue;
            
            console.log('🔄 Hidden inputs synced:', {
                primary: primaryValue,
                slideshowCount: selectedImages.length > 0 ? selectedImages.length - 1 : 0,
                slideshow: selectedImages.slice(1)
            });
        } else {
            console.warn('⚠️ Hidden inputs not found!');
        }
    }

    // Load media library
    function loadMediaLibrary() {
        fetch(`/admin/homepage/${sectionKey}/media`)
            .then(res => res.json())
            .then(data => {
                allImages = data.all_images || [];
                selectedImages = data.selected_images || [];
                
                console.log('📚 Media library loaded:', {
                    allImages: allImages.length,
                    selectedImages: selectedImages.length,
                    firstImage: selectedImages[0] || null
                });
                
                renderMediaLibrary();
                renderSelectedImages();
                
                // IMPORTANT: Update preview dan hidden inputs setelah load
                updateHeroPreview();
                syncHiddenInputs();
            })
            .catch(error => {
                console.error('Error loading media library:', error);
                document.getElementById('media-library').innerHTML =
                    '<p class="text-sm text-red-400 col-span-full text-center py-8">Error loading media library</p>';
            });
    }

    // Render media library grid
    function renderMediaLibrary() {
        const container = document.getElementById('media-library');
        document.getElementById('library-count').textContent = allImages.length;

        if (allImages.length === 0) {
            container.innerHTML = '<p class="text-sm text-slate-400 col-span-full text-center py-8">No images in library yet</p>';
            return;
        }

        container.innerHTML = allImages.map(image => {
            const isSelected = selectedImages.includes(image);
            return `
                <div class="relative group aspect-square rounded-lg overflow-hidden border-2 ${isSelected ? 'border-blue-500' : 'border-slate-200'} cursor-pointer transition hover:shadow-lg"
                     onclick="toggleImage('${image}')">
                    <img src="/storage/${image}" alt="${image}" class="w-full h-full object-cover">
                    ${isSelected ? `
                        <div class="absolute inset-0 bg-blue-500/30 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    ` : ''}
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                        <button type="button"
                                onclick="event.stopPropagation(); deleteImage('${image}')"
                                class="p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Render selected images
    function renderSelectedImages() {
        const container = document.getElementById('selected-images');
        document.getElementById('selected-count').textContent = selectedImages.length;

        if (selectedImages.length === 0) {
            container.innerHTML = '<p class="text-sm text-slate-400 col-span-full text-center py-8">No images selected yet</p>';
            return;
        }

        container.innerHTML = selectedImages.map((image, index) => `
            <div class="relative group aspect-square rounded-lg overflow-hidden border-2 ${index === 0 ? 'border-green-500' : 'border-slate-200'}">
                <img src="/storage/${image}" alt="${image}" class="w-full h-full object-cover">
                ${index === 0 ? `
                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-b from-green-500/90 to-transparent p-2">
                        <span class="px-2 py-1 bg-white text-green-600 text-[10px] rounded-full font-semibold">👑 Primary</span>
                    </div>
                ` : `
                    <div class="absolute top-0 left-0 right-0 bg-gradient-to-b from-black/60 to-transparent p-2">
                        <span class="px-2 py-1 bg-white/90 text-slate-700 text-[10px] rounded-full font-semibold">#${index + 1}</span>
                    </div>
                `}
                <button type="button"
                        onclick="toggleImage('${image}')"
                        class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition hover:bg-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `).join('');
    }

    // Toggle image selection
    function toggleImage(imagePath) {
        const index = selectedImages.indexOf(imagePath);
        if (index > -1) {
            // Remove from selected
            selectedImages.splice(index, 1);
        } else {
            // Add to selected
            selectedImages.push(imagePath);
        }
        renderMediaLibrary();
        renderSelectedImages();
        updateHeroPreview();
        syncHiddenInputs();

        // Auto-save when selection changes (backup)
        saveSelectedImages();
    }

    // Update hero preview with first selected image
    function updateHeroPreview() {
        const previewImg = document.getElementById('hero-preview-img');
        const placeholder = document.getElementById('hero-preview-placeholder');

        console.log('🖼️ Updating preview...', {
            selectedCount: selectedImages.length,
            firstImage: selectedImages[0] || null,
            hasPreviewImg: !!previewImg,
            hasPlaceholder: !!placeholder
        });

        if (selectedImages.length > 0) {
            const firstImage = selectedImages[0];

            if (previewImg) {
                previewImg.src = `/storage/${firstImage}`;
                previewImg.style.display = 'block';
                console.log('✅ Preview image set:', firstImage);
            }
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        } else {
            // Show placeholder jika tidak ada gambar
            if (previewImg) {
                previewImg.style.display = 'none';
            }
            if (placeholder) {
                placeholder.style.display = 'flex';
            }
            console.log('⚠️ No images selected, showing placeholder');
        }
    }

    // Save selected images
    function saveSelectedImages(showAlertOnError = false) {
        return fetch(`/admin/homepage/${sectionKey}/media/save-selected`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ selected_images: selectedImages })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('HTTP error! status: ' + res.status);
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                console.log('✓ Saved', data.count, 'images for slideshow');
                if (!showAlertOnError || data.count > 0) {
                    showNotification(`✅ Berhasil menyimpan ${data.count} gambar untuk slideshow!`);
                }
            }
            return data;
        })
        .catch(error => {
            console.error('Error saving selected images:', error);
            if (showAlertOnError) {
                showNotification('❌ Gagal menyimpan gambar slideshow!', 'error');
            }
            return null;
        });
    }

    // Select all images
    function selectAllImages() {
        selectedImages = [...allImages];
        renderMediaLibrary();
        renderSelectedImages();
        saveSelectedImages();
    }

    // Handle upload
    async function handleUpload(input) {
        const files = input.files;
        if (!files || files.length === 0) return;

        console.log('📤 Starting upload:', files.length, 'file(s)');

        const formData = new FormData();
        formData.append('_token', csrfToken);

        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
            console.log('  📎 File', i + 1 + ':', files[i].name, '(', Math.round(files[i].size / 1024), 'KB )');
        }

        // Show loading
        const libraryContainer = document.getElementById('media-library');
        libraryContainer.innerHTML = '<p class="text-sm text-blue-400 col-span-full text-center py-8">⏳ Uploading ' + files.length + ' file(s)...</p>';

        try {
            const res = await fetch(`/admin/homepage/${sectionKey}/media/upload`, {
                method: 'POST',
                body: formData
            });

            if (!res.ok) {
                throw new Error('HTTP error! status: ' + res.status);
            }

            const data = await res.json();
            console.log('📥 Upload response:', data);

            if (data.success) {
                const newImages = data.paths || [];
                console.log('✅ Upload successful, new images:', newImages);
                
                allImages = [...new Set([...allImages, ...newImages])];
                selectedImages = [...new Set([...selectedImages, ...newImages])];
                
                console.log('📊 Current state:', {
                    allImages: allImages.length,
                    selectedImages: selectedImages.length,
                    firstSelected: selectedImages[0] || null
                });
                
                renderMediaLibrary();
                renderSelectedImages();
                updateHeroPreview();
                syncHiddenInputs();

                const saveResult = await saveSelectedImages(false);
                if (!saveResult || !saveResult.success) {
                    console.warn('⚠️ Failed to auto-save selected images, but upload was successful');
                }

                loadMediaLibrary();
                showNotification(`✅ Berhasil mengupload ${data.paths.length} gambar!`);
            } else {
                const errorMsg = data.error || data.message || 'Unknown error';
                console.error('❌ Upload failed:', errorMsg);
                showNotification('❌ Upload failed: ' + errorMsg, 'error');
                loadMediaLibrary();
            }
        } catch (error) {
            console.error('💥 Upload error:', error);
            let errorMsg = 'Network error or invalid route';
            if (error.message) {
                errorMsg = error.message;
            }
            showNotification('❌ Upload failed: ' + errorMsg, 'error');
            loadMediaLibrary();
        }

        // Reset input
        input.value = '';
    }

    // Delete image
    function deleteImage(imagePath) {
        if (!confirm('Delete this image from library? This will remove it from all slideshows.')) return;

        fetch(`/admin/homepage/${sectionKey}/media/${encodeURIComponent(imagePath)}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove from allImages
                allImages = allImages.filter(img => img !== imagePath);
                // Remove from selectedImages
                selectedImages = selectedImages.filter(img => img !== imagePath);
                renderMediaLibrary();
                renderSelectedImages();
            } else {
                alert('Delete failed: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Delete failed!');
        });
    }

    // Preview opacity
    document.getElementById('opacity-range')?.addEventListener('input', function() {
        const percentage = Math.round(this.value * 100);
        this.previousElementSibling.textContent = `Overlay Opacity (${percentage}%)`;
    });

    // ===== SLIDE TEXT MANAGEMENT =====
    
    // Initialize slide texts on page load
    function initializeSlideTexts() {
        const slideTextsJson = document.getElementById('slide-texts-json').value;
        let slideTexts = [];
        
        try {
            if (slideTextsJson) {
                slideTexts = JSON.parse(slideTextsJson) || [];
            }
        } catch (e) {
            console.warn('Failed to parse slide texts:', e);
            slideTexts = [];
        }

        // If no slide texts exist yet, create defaults based on selected images
        if (slideTexts.length === 0 && selectedImages.length > 0) {
            slideTexts = selectedImages.map((img, idx) => ({
                title: idx === 0 ? (document.querySelector('input[name="title"]')?.value || '') : '',
                subtitle: idx === 0 ? (document.querySelector('input[name="subtitle"]')?.value || '') : ''
            }));
        }

        renderSlideTexts(slideTexts);
    }

    // Render slide text fields
    function renderSlideTexts(slideTexts) {
        const container = document.getElementById('slide-texts-container');
        
        if (!container) return;

        if (slideTexts.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-slate-500">
                    <p class="text-sm">Belum ada slide. Tambahkan gambar di Media Library terlebih dahulu.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = slideTexts.map((slide, index) => `
            <div class="slide-text-card bg-white rounded-xl border border-slate-200 p-4 transition-all hover:shadow-md" data-slide-index="${index}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm">
                            ${index + 1}
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-900">Slide ${index + 1}</h4>
                            ${selectedImages[index] ? `<p class="text-xs text-slate-500 truncate max-w-[200px]">${selectedImages[index]}</p>` : ''}
                        </div>
                    </div>
                    ${slideTexts.length > 1 ? `
                        <button type="button" 
                                onclick="removeSlide(${index})"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                title="Hapus slide ini">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    ` : ''}
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Judul</label>
                        <input type="text"
                               value="${slide.title || ''}"
                               placeholder="Judul slide ${index + 1}"
                               onchange="updateSlideText(${index}, 'title', this.value)"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Subjudul</label>
                        <input type="text"
                               value="${slide.subtitle || ''}"
                               placeholder="Subjudul slide ${index + 1}"
                               onchange="updateSlideText(${index}, 'subtitle', this.value)"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
        `).join('');

        // Update hidden input
        updateSlideTextsHidden(slideTexts);
    }

    // Update slide text value
    function updateSlideText(index, field, value) {
        const slideTextsJson = document.getElementById('slide-texts-json').value;
        let slideTexts = [];
        
        try {
            slideTexts = JSON.parse(slideTextsJson) || [];
        } catch (e) {
            slideTexts = [];
        }

        if (!slideTexts[index]) {
            slideTexts[index] = {};
        }

        slideTexts[index][field] = value;
        updateSlideTextsHidden(slideTexts);
        
        console.log(`✅ Updated slide ${index + 1} ${field}:`, value);
    }

    // Update hidden input with slide texts
    function updateSlideTextsHidden(slideTexts) {
        const hiddenInput = document.getElementById('slide-texts-json');
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify(slideTexts);
        }
    }

    // Add new slide
    function addNewSlide() {
        const slideTextsJson = document.getElementById('slide-texts-json').value;
        let slideTexts = [];
        
        try {
            slideTexts = JSON.parse(slideTextsJson) || [];
        } catch (e) {
            slideTexts = [];
        }

        slideTexts.push({ title: '', subtitle: '' });
        renderSlideTexts(slideTexts);
        updateSlideTextsHidden(slideTexts);
        
        showNotification('✅ Slide baru ditambahkan!');
    }

    // Remove slide
    function removeSlide(index) {
        if (!confirm('Hapus slide ini?')) return;

        const slideTextsJson = document.getElementById('slide-texts-json').value;
        let slideTexts = [];
        
        try {
            slideTexts = JSON.parse(slideTextsJson) || [];
        } catch (e) {
            slideTexts = [];
        }

        slideTexts.splice(index, 1);
        renderSlideTexts(slideTexts);
        updateSlideTextsHidden(slideTexts);
        
        showNotification('🗑️ Slide dihapus!');
    }

    // Initialize slide texts after media library loads
    const originalLoadMediaLibrary = loadMediaLibrary;
    loadMediaLibrary = function() {
        originalLoadMediaLibrary();
        
        // Override the original's success handler to also initialize slide texts
        const originalThen = fetch;
        setTimeout(() => {
            initializeSlideTexts();
        }, 500);
    };

    // Also initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSlideTexts);
    } else {
        initializeSlideTexts();
    }

    // Re-initialize when images change
    const originalRenderSelectedImages = renderSelectedImages;
    renderSelectedImages = function() {
        originalRenderSelectedImages();
        initializeSlideTexts();
    };
</script>

<style>
    /* Custom scrollbar for media library */
    #media-library, #selected-images {
        max-height: 400px;
        overflow-y: auto;
    }
    
    #media-library::-webkit-scrollbar, #selected-images::-webkit-scrollbar {
        width: 6px;
    }
    
    #media-library::-webkit-scrollbar-track, #selected-images::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 99px;
    }
    
    #media-library::-webkit-scrollbar-thumb, #selected-images::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 99px;
    }
    
    #media-library::-webkit-scrollbar-thumb:hover, #selected-images::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush

