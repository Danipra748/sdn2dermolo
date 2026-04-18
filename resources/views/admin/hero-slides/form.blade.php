@extends('admin.layout')

@php
    $isEdit = isset($slide) && $slide->id;
    $title = $isEdit ? 'Edit Slide' : 'Tambah Slide Baru';
@endphp

@section('title', $title)
@section('heading', $title)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <style>
        .cropper-container { max-height: 450px; }
        #crop-image { max-width: 100%; display: block; }
    </style>
@endpush

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Kelola gambar besar yang tampil di halaman depan website."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $isEdit ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6 space-y-6">
                <x-admin.form-group label="Judul Slide" name="title" required>
                    <input type="text" name="title" value="{{ old('title', $slide->title ?? '') }}" class="form-input" required>
                </x-admin.form-group>
                
                <x-admin.form-group label="Sub-judul (Opsional)" name="subtitle">
                    <input type="text" name="subtitle" value="{{ old('subtitle', $slide->subtitle ?? '') }}" class="form-input">
                </x-admin.form-group>

                <div class="grid md:grid-cols-2 gap-6">
                    <x-admin.form-group label="Urutan Tampil" name="display_order">
                        <input type="number" name="display_order" value="{{ old('display_order', $slide->display_order ?? '99') }}" class="form-input w-24">
                    </x-admin.form-group>
                    <x-admin.form-group label="Status" name="is_active">
                        <select name="is_active" class="form-input">
                            <option value="1" @selected(old('is_active', $slide->is_active ?? true))>Aktif</option>
                            <option value="0" @selected(!old('is_active', $slide->is_active ?? true))>Nonaktif</option>
                        </select>
                    </x-admin.form-group>
                </div>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">Gambar Slide</h3>
                <x-admin.form-group label="Upload Gambar" name="image" :required="!$isEdit" help="Rasio 16:9 (1920x1080) sangat disarankan untuk hasil terbaik.">
                    <input type="file" id="image-input" name="image" class="file-input" accept="image/*">
                </x-admin.form-group>

                {{-- Hidden inputs for crop data --}}
                <input type="hidden" name="crop_x" id="crop_x">
                <input type="hidden" name="crop_y" id="crop_y">
                <input type="hidden" name="crop_w" id="crop_w">
                <input type="hidden" name="crop_h" id="crop_h">
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.hero-slides.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Slide' }}</x-admin.button>
            </div>
        </form>
    </div>

    {{-- Cropping Modal --}}
    <div id="crop-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-6 max-w-2xl w-full shadow-2xl">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Crop Gambar (16:9)</h3>
            <div class="cropper-container mb-6 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center">
                <img id="crop-image" src="">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeCropModal()" class="flex-1 px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="button" onclick="confirmCrop()" class="flex-1 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-600/30">
                    Gunakan Hasil Crop
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
    let cropper = null;
    const imageInput = document.getElementById('image-input');
    const cropModal = document.getElementById('crop-modal');
    const cropImage = document.getElementById('crop-image');

    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(e) {
                cropImage.src = e.target.result;
                openCropModal();
            };
            reader.readAsDataURL(files[0]);
        }
    });

    function openCropModal() {
        cropModal.classList.remove('hidden');
        cropModal.classList.add('flex');
        
        if (cropper) cropper.destroy();
        
        setTimeout(() => {
            cropper = new Cropper(cropImage, {
                aspectRatio: 16 / 9,
                viewMode: 2,
                autoCropArea: 1,
            });
        }, 100);
    }

    function closeCropModal() {
        cropModal.classList.add('hidden');
        cropModal.classList.remove('flex');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        imageInput.value = '';
    }

    function confirmCrop() {
        if (!cropper) return;
        
        const data = cropper.getData();
        document.getElementById('crop_x').value = Math.round(data.x);
        document.getElementById('crop_y').value = Math.round(data.y);
        document.getElementById('crop_w').value = Math.round(data.width);
        document.getElementById('crop_h').value = Math.round(data.height);
        
        cropModal.classList.add('hidden');
        cropModal.classList.remove('flex');
    }
</script>
@endpush
