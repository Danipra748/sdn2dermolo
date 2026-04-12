@extends('admin.layout')

@section('title', 'Pengelolaan Hero Slides')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengelolaan Hero Slides</h1>
            <p class="text-slate-600 mt-1">Kelola beberapa gambar slide untuk hero section beranda</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    {{-- Add New Slide Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-bold text-slate-900 mb-4">Tambah Slide Baru</h2>
        <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Gambar Slide (Wajib)</label>
                <input type="file" name="image" accept="image/jpeg,image/jpg,image/png,image/webp" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WebP. Maksimal 3MB.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul (Opsional)</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: SD N 2 Dermolo">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Subjudul (Opsional)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Generasi Unggul">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="2"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Deskripsi tambahan untuk slide ini...">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Slide
                </button>
            </div>
        </form>
    </div>

    {{-- Slides List with Drag & Drop --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900">Daftar Slide ({{ $slides->count() }})</h2>
            <p class="text-sm text-slate-500">Drag & drop untuk mengubah urutan</p>
        </div>

        @if($slides->count() > 0)
        <div id="slides-sortable" class="space-y-3">
            @foreach($slides as $index => $slide)
            <div class="slide-item border border-slate-200 rounded-lg p-4 bg-slate-50 hover:bg-white hover:shadow-md transition" data-slide-id="{{ $slide->id }}">
                <div class="flex items-start gap-4">
                    {{-- Drag Handle --}}
                    <div class="drag-handle cursor-move flex-shrink-0 text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                        </svg>
                    </div>

                    {{-- Order Number --}}
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                        {{ $index + 1 }}
                    </div>

                    {{-- Slide Image Preview --}}
                    <div class="flex-shrink-0 w-32 h-20 rounded-lg overflow-hidden bg-slate-200">
                        <img src="{{ asset('storage/' . $slide->image_path) }}" alt="Slide" class="w-full h-full object-cover">
                    </div>

                    {{-- Slide Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                @if($slide->title)
                                <h3 class="font-bold text-slate-900 truncate">{{ $slide->title }}</h3>
                                @endif
                                @if($slide->subtitle)
                                <p class="text-sm text-blue-600 font-medium">{{ $slide->subtitle }}</p>
                                @endif
                                @if($slide->description)
                                <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ Str::limit($slide->description, 100) }}</p>
                                @endif
                            </div>

                            {{-- Status Badge --}}
                            <div class="flex-shrink-0">
                                @if($slide->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                                    Nonaktif
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2 mt-3">
                            {{-- Move Up --}}
                            @if(!$loop->first)
                            <form action="{{ route('admin.hero-slides.move-up', $slide) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-slate-300 rounded text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                    Atas
                                </button>
                            </form>
                            @endif

                            {{-- Move Down --}}
                            @if(!$loop->last)
                            <form action="{{ route('admin.hero-slides.move-down', $slide) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-slate-300 rounded text-xs font-medium text-slate-700 hover:bg-slate-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                    Bawah
                                </button>
                            </form>
                            @endif

                            {{-- Toggle Active --}}
                            <form action="{{ route('admin.hero-slides.toggle-active', $slide) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-slate-300 rounded text-xs font-medium {{ $slide->is_active ? 'text-amber-700 hover:bg-amber-50' : 'text-green-700 hover:bg-green-50' }} transition">
                                    @if($slide->is_active)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    Nonaktifkan
                                    @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Aktifkan
                                    @endif
                                </button>
                            </form>

                            {{-- Edit --}}
                            <button type="button" onclick="openEditModal({{ $slide->id }})" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded text-xs font-medium hover:bg-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus slide ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-xs font-medium hover:bg-red-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Edit Modal Data --}}
            <div id="edit-modal-{{ $slide->id }}" class="hidden fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Slide</h3>
                    <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Gambar Baru (Opsional)</label>
                            <input type="file" name="image" accept="image/jpeg,image/jpg,image/png,image/webp"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Judul</label>
                            <input type="text" name="title" value="{{ $slide->title }}"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Subjudul</label>
                            <input type="text" name="subtitle" value="{{ $slide->subtitle }}"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $slide->description }}</textarea>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="is_active_{{ $slide->id }}" value="1" {{ $slide->is_active ? 'checked' : '' }}
                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <label for="is_active_{{ $slide->id }}" class="text-sm text-slate-700">Slide Aktif</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" onclick="closeEditModal({{ $slide->id }})" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-slate-500">Belum ada slide. Tambahkan slide pertama di atas.</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Drag and Drop functionality for slide ordering
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('slides-sortable');
    if (!container) return;

    let draggedItem = null;

    container.addEventListener('dragstart', function(e) {
        draggedItem = e.target.closest('.slide-item');
        if (draggedItem) {
            draggedItem.style.opacity = '0.5';
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    container.addEventListener('dragend', function(e) {
        if (draggedItem) {
            draggedItem.style.opacity = '1';
            draggedItem = null;

            // Update order via AJAX
            updateSlideOrder();
        }
    });

    container.addEventListener('dragover', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(container, e.clientY);
        if (afterElement == null) {
            container.appendChild(draggedItem);
        } else {
            container.insertBefore(draggedItem, afterElement);
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.slide-item:not([style*="opacity: 0.5"])')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function updateSlideOrder() {
        const items = container.querySelectorAll('.slide-item');
        const orderedIds = Array.from(items).map(item => parseInt(item.dataset.slideId));

        fetch('{{ route('admin.hero-slides.reorder') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ ordered_ids: orderedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success notification
                showNotification('Urutan slide berhasil diperbarui.', 'success');
            }
        })
        .catch(error => {
            console.error('Error updating order:', error);
            showNotification('Gagal memperbarui urutan slide.', 'error');
        });
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});

function openEditModal(slideId) {
    const modal = document.getElementById('edit-modal-' + slideId);
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeEditModal(slideId) {
    const modal = document.getElementById('edit-modal-' + slideId);
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('fixed')) {
        e.target.classList.add('hidden');
    }
});
</script>
@endpush
@endsection
