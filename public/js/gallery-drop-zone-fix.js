/**
 * Gallery Drop Zone Fix - Specific Handler for Gallery Photo Upload
 * 
 * Target: Halaman Admin Galeri Foto
 * Element ID: foto-input
 * 
 * Fitur:
 * - Drag & Drop foto ke kotak unggah
 * - Preview gambar setelah file dipilih
 * - Validasi format & ukuran file
 * - Tombol hapus untuk batalkan pilihan
 * - Teks petunjuk Bahasa Indonesia
 */

(function() {
    'use strict';

    // Configuration - Unique for Gallery
    const GALLERY_DROP_CONFIG = {
        targetId: 'foto-input',              // Unique ID for gallery photo input
        acceptedTypes: [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/webp'
        ],
        acceptedExtensions: '.jpg, .jpeg, .png, .webp',
        maxSize: 2 * 1024 * 1024,            // 2MB
        maxSizeDisplay: '2MB',
        placeholderText: 'Seret foto ke sini atau klik untuk mengunggah',
        removeButtonText: 'Hapus'
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
    function validateGalleryFile(file) {
        if (!GALLERY_DROP_CONFIG.acceptedTypes.includes(file.type)) {
            return {
                valid: false,
                message: 'Format file tidak didukung. Gunakan: ' + GALLERY_DROP_CONFIG.acceptedExtensions
            };
        }

        if (file.size > GALLERY_DROP_CONFIG.maxSize) {
            return {
                valid: false,
                message: 'Ukuran file terlalu besar. Maksimal ' + GALLERY_DROP_CONFIG.maxSizeDisplay
            };
        }

        return { valid: true };
    }

    // Show error message
    function showGalleryError(wrapper, message) {
        let errorEl = wrapper.querySelector('.gallery-drop-error');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'gallery-drop-error';
            wrapper.appendChild(errorEl);
        }
        errorEl.textContent = message;
        errorEl.style.display = 'block';

        setTimeout(() => {
            errorEl.style.display = 'none';
        }, 5000);
    }

    // Hide error message
    function hideGalleryError(wrapper) {
        const errorEl = wrapper.querySelector('.gallery-drop-error');
        if (errorEl) {
            errorEl.style.display = 'none';
        }
    }

    // Create custom drop zone HTML for Gallery
    function createGalleryDropZoneHTML(originalInput) {
        const isRequired = originalInput.hasAttribute('required');
        const acceptAttr = originalInput.getAttribute('accept') || GALLERY_DROP_CONFIG.acceptedExtensions;
        const inputId = originalInput.id || 'gallery-foto-' + Date.now();
        const inputName = originalInput.name || 'foto';

        return `
            <div class="gallery-drop-wrapper" style="position: relative; margin-top: 0.5rem;">
                <div class="gallery-drop-zone" data-gallery-drop-zone style="
                    border: 2px dashed #CBD5E1;
                    border-radius: 12px;
                    padding: 2.5rem 1.5rem;
                    text-align: center;
                    cursor: pointer;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    background: #F8FAFC;
                    position: relative;
                ">
                    <input type="file"
                           name="${inputName}"
                           id="${inputId}"
                           accept="${acceptAttr}"
                           style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 10;"
                           data-gallery-file-input
                           ${isRequired ? 'required' : ''}>

                    <div class="gallery-drop-content" data-gallery-drop-content style="pointer-events: none;">
                        <div style="margin-bottom: 1rem; color: #94A3B8;">
                            <svg style="width: 64px; height: 64px; margin: 0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p style="color: #475569; font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem;">
                            <strong>${GALLERY_DROP_CONFIG.placeholderText}</strong>
                        </p>
                        <p style="color: #94A3B8; font-size: 0.85rem;">
                            Format: ${GALLERY_DROP_CONFIG.acceptedExtensions} (Maks. ${GALLERY_DROP_CONFIG.maxSizeDisplay})
                        </p>
                    </div>

                    <div class="gallery-drop-preview" data-gallery-drop-preview style="
                        margin-top: 1rem;
                        display: none;
                    ">
                        <img src="" alt="Preview" data-gallery-preview-img style="
                            max-width: 100%;
                            max-height: 250px;
                            border-radius: 10px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                            object-fit: cover;
                        ">
                    </div>
                </div>

                <div class="gallery-drop-file-info" data-gallery-file-info style="
                    margin-top: 0.75rem;
                    padding: 0.875rem;
                    background: white;
                    border-radius: 10px;
                    border: 1px solid #E2E8F0;
                    display: none;
                    align-items: center;
                    gap: 0.75rem;
                ">
                    <div style="font-size: 1.5rem; flex-shrink: 0;">📷</div>
                    <div style="flex: 1; text-align: left; min-width: 0;">
                        <div data-gallery-file-name style="
                            font-size: 0.875rem;
                            font-weight: 600;
                            color: #334155;
                            margin-bottom: 0.25rem;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        ">-</div>
                        <div data-gallery-file-size style="font-size: 0.75rem; color: #64748B;">-</div>
                    </div>
                    <button type="button" data-gallery-remove-file style="
                        background: #FEE2E2;
                        color: #DC2626;
                        border: 1px solid #FECACA;
                        border-radius: 8px;
                        padding: 0.5rem 0.875rem;
                        font-size: 0.8rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.2s ease;
                        flex-shrink: 0;
                        white-space: nowrap;
                    ">${GALLERY_DROP_CONFIG.removeButtonText}</button>
                </div>

                <div class="gallery-drop-error" style="
                    margin-top: 0.5rem;
                    padding: 0.625rem 0.875rem;
                    background: #FEF2F2;
                    border: 1px solid #FECACA;
                    border-radius: 8px;
                    color: #DC2626;
                    font-size: 0.8rem;
                    display: none;
                "></div>
            </div>
        `;
    }

    // Handle file selection for Gallery
    function handleGalleryFile(wrapper, file) {
        const validation = validateGalleryFile(file);

        if (!validation.valid) {
            showGalleryError(wrapper, validation.message);
            return false;
        }

        hideGalleryError(wrapper);

        const fileInput = wrapper.querySelector('[data-gallery-file-input]');
        const preview = wrapper.querySelector('[data-gallery-drop-preview]');
        const previewImage = wrapper.querySelector('[data-gallery-preview-img]');
        const content = wrapper.querySelector('[data-gallery-drop-content]');
        const dropZone = wrapper.querySelector('[data-gallery-drop-zone]');
        const fileInfo = wrapper.querySelector('[data-gallery-file-info]');
        const fileName = wrapper.querySelector('[data-gallery-file-name]');
        const fileSize = wrapper.querySelector('[data-gallery-file-size]');

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
                preview.style.display = 'block';
                content.style.display = 'none';
                dropZone.style.borderColor = '#10B981';
                dropZone.style.borderStyle = 'solid';
                dropZone.style.background = '#F0FDF4';
            };
            reader.readAsDataURL(file);
        } else {
            content.style.display = 'none';
            dropZone.style.borderColor = '#10B981';
            dropZone.style.borderStyle = 'solid';
            dropZone.style.background = '#F0FDF4';
        }

        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileInfo.style.display = 'flex';

        return true;
    }

    // Initialize Gallery Drop Zone
    function initializeGalleryDropZone() {
        const originalInput = document.getElementById(GALLERY_DROP_CONFIG.targetId);

        // If input not found, skip
        if (!originalInput) {
            console.warn('[Gallery Drop Zone] Input #' + GALLERY_DROP_CONFIG.targetId + ' not found. Skipping initialization.');
            return;
        }

        // Skip if already wrapped
        if (originalInput.parentElement && originalInput.parentElement.classList.contains('gallery-drop-wrapper')) {
            console.log('[Gallery Drop Zone] Already initialized. Skipping.');
            return;
        }

        // Skip if already transformed by global drop zone
        if (originalInput.dataset.dropZoneInitialized === 'true') {
            console.log('[Gallery Drop Zone] Already initialized by global handler. Skipping.');
            return;
        }

        console.log('[Gallery Drop Zone] Initializing for #' + GALLERY_DROP_CONFIG.targetId + '...');

        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.innerHTML = createGalleryDropZoneHTML(originalInput);

        // Replace original input with drop zone
        originalInput.parentNode.replaceChild(wrapper.firstElementChild, originalInput);

        const finalWrapper = document.previousElementSibling || wrapper.firstElementChild;
        const dropZone = finalWrapper.querySelector('[data-gallery-drop-zone]');
        const fileInput = finalWrapper.querySelector('[data-gallery-file-input]');
        const removeBtn = finalWrapper.querySelector('[data-gallery-remove-file]');

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
                dropZone.style.borderColor = '#10B981';
                dropZone.style.background = 'linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%)';
                dropZone.style.transform = 'scale(1.02)';
            });
        });

        // Unhighlight on drag leave/drop
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                if (!fileInput.files.length) {
                    dropZone.style.borderColor = '#CBD5E1';
                    dropZone.style.background = '#F8FAFC';
                }
                dropZone.style.transform = 'scale(1)';
            });
        });

        // Handle drop
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                console.log('[Gallery Drop Zone] File dropped:', files[0].name);
                handleGalleryFile(finalWrapper, files[0]);
            }
        });

        // Handle file input change
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                console.log('[Gallery Drop Zone] File selected:', e.target.files[0].name);
                handleGalleryFile(finalWrapper, e.target.files[0]);
            }
        });

        // Handle remove file
        removeBtn.addEventListener('click', () => {
            fileInput.value = '';

            const preview = finalWrapper.querySelector('[data-gallery-drop-preview]');
            const previewImage = finalWrapper.querySelector('[data-gallery-preview-img]');
            const content = finalWrapper.querySelector('[data-gallery-drop-content]');
            const fileInfo = finalWrapper.querySelector('[data-gallery-file-info]');

            previewImage.src = '';
            preview.style.display = 'none';
            content.style.display = 'block';
            dropZone.style.borderColor = '#CBD5E1';
            dropZone.style.borderStyle = 'dashed';
            dropZone.style.background = '#F8FAFC';
            fileInfo.style.display = 'none';

            hideGalleryError(finalWrapper);

            console.log('[Gallery Drop Zone] File removed.');
        });

        console.log('[Gallery Drop Zone] ✅ Successfully initialized!');
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeGalleryDropZone);
    } else {
        initializeGalleryDropZone();
    }

    // Expose for re-initialization if needed (e.g., after AJAX/SPA navigation)
    window.initializeGalleryDropZone = initializeGalleryDropZone;

    console.log('[Gallery Drop Zone] Script loaded. Waiting for DOM...');

})();
