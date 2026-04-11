/**
 * Drop Zone Handler - Global Drag & Drop Functionality
 * Automatically converts file inputs to modern drag-drop zones
 * 
 * Usage:
 * - Just add class "drop-zone-enabled" to any <input type="file">
 * - Script will automatically convert it to a modern drop zone
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        // Allowed file types (image only)
        allowedTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'],
        
        // Max file size in bytes (2MB)
        maxSize: 2 * 1024 * 1024,
        
        // Allowed extensions for display
        allowedExtensions: '.jpg, .jpeg, .png, .webp, .gif',
        
        // Max size display
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
        // Check if file is image
        if (!config.allowedTypes.includes(file.type)) {
            return {
                valid: false,
                message: 'Format file tidak didukung. Gunakan: ' + config.allowedExtensions
            };
        }

        // Check file size
        if (file.size > config.maxSize) {
            return {
                valid: false,
                message: 'Ukuran file terlalu besar. Maksimal ' + config.maxSizeDisplay
            };
        }

        return { valid: true };
    }

    // Show error
    function showError(wrapper, message) {
        let errorEl = wrapper.querySelector('.drop-zone-error');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'drop-zone-error';
            wrapper.appendChild(errorEl);
        }
        errorEl.textContent = message;
        errorEl.classList.add('show');
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            errorEl.classList.remove('show');
        }, 5000);
    }

    // Hide error
    function hideError(wrapper) {
        const errorEl = wrapper.querySelector('.drop-zone-error');
        if (errorEl) {
            errorEl.classList.remove('show');
        }
    }

    // Create drop zone HTML
    function createDropZoneHTML(input) {
        const isRequired = input.hasAttribute('required');
        const acceptAttr = input.getAttribute('accept') || config.allowedExtensions;
        
        return `
            <div class="drop-zone-wrapper">
                <div class="drop-zone" data-drop-zone>
                    <input type="file" 
                           name="${input.name}" 
                           accept="${acceptAttr}"
                           class="file-input-hidden" 
                           data-file-input
                           ${isRequired ? 'required' : ''}
                           ${input.id ? 'id="' + input.id + '"' : ''}>
                    
                    <div class="drop-zone-content" data-drop-zone-content>
                        <div class="drop-zone-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="drop-zone-text">
                            <strong>Tarik dan lepaskan file di sini</strong> atau klik untuk mengunggah
                        </p>
                        <p class="drop-zone-hint">Format: ${config.allowedExtensions} (Maks. ${config.maxSizeDisplay})</p>
                    </div>

                    <div class="drop-zone-preview" data-drop-zone-preview>
                        <img src="" alt="Preview" data-preview-image>
                    </div>
                </div>

                <div class="drop-zone-file-info" data-file-info>
                    <div class="drop-zone-file-info-icon">📷</div>
                    <div class="drop-zone-file-info-details">
                        <div class="drop-zone-file-info-name" data-file-name>-</div>
                        <div class="drop-zone-file-info-size" data-file-size>-</div>
                    </div>
                    <button type="button" class="drop-zone-file-remove" data-remove-file>Hapus</button>
                </div>
            </div>
        `;
    }

    // Handle file selection
    function handleFile(wrapper, dropZone, file) {
        const validation = validateFile(file);
        
        if (!validation.valid) {
            showError(wrapper, validation.message);
            return false;
        }

        hideError(wrapper);

        const fileInput = dropZone.querySelector('[data-file-input]');
        const preview = dropZone.querySelector('[data-drop-zone-preview]');
        const previewImage = dropZone.querySelector('[data-preview-image]');
        const content = dropZone.querySelector('[data-drop-zone-content]');
        const fileInfo = wrapper.querySelector('[data-file-info]');
        const fileName = wrapper.querySelector('[data-file-name]');
        const fileSize = wrapper.querySelector('[data-file-size]');

        // Set file to input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;

        // Trigger change event for compatibility
        const event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);

        // Show preview for images
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.add('show');
                content.style.display = 'none';
                dropZone.classList.add('has-file');
            };
            reader.readAsDataURL(file);
        } else {
            // Non-image file - just show info
            content.style.display = 'none';
            dropZone.classList.add('has-file');
        }

        // Show file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileInfo.classList.add('show');

        return true;
    }

    // Initialize drop zone for a single input
    function initializeDropZone(input) {
        // Skip if already initialized
        if (input.dataset.dropZoneInitialized === 'true') {
            return;
        }

        // Create wrapper and insert drop zone HTML
        const wrapper = document.createElement('div');
        wrapper.className = 'drop-zone-enabled-wrapper';
        wrapper.innerHTML = createDropZoneHTML(input);
        
        // Replace original input with drop zone
        input.parentNode.replaceChild(wrapper, input);

        const dropZone = wrapper.querySelector('[data-drop-zone]');
        const fileInput = wrapper.querySelector('[data-file-input]');
        const removeBtn = wrapper.querySelector('[data-remove-file]');

        // Drag events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('drag-over');
            });
        });

        // Drop event
        dropZone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(wrapper, dropZone, files[0]);
            }
        });

        // Click to select file (fileInput is transparent overlay)
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFile(wrapper, dropZone, e.target.files[0]);
            }
        });

        // Remove file
        removeBtn.addEventListener('click', () => {
            fileInput.value = '';
            
            const preview = dropZone.querySelector('[data-drop-zone-preview]');
            const previewImage = dropZone.querySelector('[data-preview-image]');
            const content = dropZone.querySelector('[data-drop-zone-content]');
            const fileInfo = wrapper.querySelector('[data-file-info]');

            previewImage.src = '';
            preview.classList.remove('show');
            content.style.display = 'block';
            dropZone.classList.remove('has-file');
            fileInfo.classList.remove('show');
            
            hideError(wrapper);
        });

        // Mark as initialized
        input.dataset.dropZoneInitialized = 'true';
    }

    // Initialize all drop zones on page
    function initializeAll() {
        const inputs = document.querySelectorAll('input[type="file"].drop-zone-enabled');
        inputs.forEach(input => initializeDropZone(input));
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeAll);
    } else {
        initializeAll();
    }

    // Expose function for dynamic content
    window.initializeDropZones = initializeAll;

    // Re-initialize on AJAX/SPA content load
    const originalFetch = window.fetch;
    window.fetch = function() {
        return originalFetch.apply(this, arguments).then(response => {
            // Re-initialize after content load
            setTimeout(initializeAll, 100);
            return response;
        });
    };

})();
