@extends('admin.layout')

@section('title', 'Sambutan & Foto Kepala Sekolah')
@section('heading', 'Sambutan & Foto Kepala Sekolah')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <style>
        .cropper-container { max-height: 450px; }
        #crop-image { max-width: 100%; display: block; }
    </style>
@endpush

@section('content')
    @if (session('success') || session('status'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') ?? session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <div class="font-semibold">Ada data yang perlu diperbaiki.</div>
            <ul class="mt-2 list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-card p-6 lg:p-8">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">Pengaturan Sambutan & Foto Resmi</h2>
            <p class="text-sm text-slate-500">Atur teks sambutan dan foto resmi yang akan ditampilkan di halaman depan dan halaman 'Tentang Kami'.</p>
        </div>

        <form action="{{ route('admin.sambutan-kepsek.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-8 md:grid-cols-5">
                {{-- Form Kiri (Teks & Aksi) --}}
                <div class="md:col-span-3 space-y-6">
                    <x-admin.form-group label="Teks Sambutan" name="sambutan" required>
                        <textarea name="sambutan" rows="16" class="form-input">{{ old('sambutan', $sambutanText) }}</textarea>
                    </x-admin.form-group>

                    <div class="flex items-center justify-end">
                        <x-admin.button type="submit" variant="primary">
                            <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></x-slot:icon>
                            Simpan Perubahan
                        </x-admin.button>
                    </div>
                </div>

                {{-- Form Kanan (Foto & Preview) --}}
                <div class="md:col-span-2">
                    <x-admin.form-group label="Foto Resmi Kepala Sekolah" name="foto" help="Rasio 4:5 sangat disarankan.">
                        <input type="file" name="foto" id="image-input" class="file-input" accept="image/*">
                    </x-admin.form-group>

                    <div class="mt-4">
                        <div class="text-sm font-semibold text-slate-700 mb-2">Preview</div>
                        <div class="w-full aspect-[4/5] rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center text-sm text-slate-400 bg-slate-50 overflow-hidden">
                             <img id="image-preview" src="{{ $fotoKepsek ? asset('storage/' . $fotoKepsek) : '' }}" alt="Preview" class="{{ $fotoKepsek ? '' : 'hidden' }} w-full h-full object-cover">
                            <span id="image-placeholder" class="{{ $fotoKepsek ? 'hidden' : '' }} text-center">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Belum ada foto
                            </span>
                        </div>
                    </div>
                    
                    @if ($fotoKepsek)
                        <div class="mt-4">
                            <label class="inline-flex items-center gap-2 text-xs">
                                <input type="checkbox" name="remove_foto" value="1" class="rounded"> Hapus foto saat ini
                            </label>
                        </div>
                    @endif

                    {{-- Hidden inputs for crop data --}}
                    <input type="hidden" name="crop_x" id="crop_x">
                    <input type="hidden" name="crop_y" id="crop_y">
                    <input type="hidden" name="crop_w" id="crop_w">
                    <input type="hidden" name="crop_h" id="crop_h">
                </div>
            </div>
        </form>
    </div>

    {{-- Cropping Modal --}}
    <div id="crop-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-6 max-w-lg w-full shadow-2xl">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Crop Foto (4:5)</h3>
            <div class="cropper-container mb-6 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center">
                <img id="crop-image" src="">
            </div>
            <div class="flex gap-3">
                <x-admin.button type="button" onclick="closeCropModal()" variant="secondary" class="w-full">Batal</x-admin.button>
                <x-admin.button type="button" onclick="confirmCrop()" variant="primary" class="w-full">Gunakan Hasil Crop</x-admin.button>
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
    const imagePreview = document.getElementById('image-preview');
    const imagePlaceholder = document.getElementById('image-placeholder');

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
                aspectRatio: 4 / 5,
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
        
        const canvas = cropper.getCroppedCanvas();
        imagePreview.src = canvas.toDataURL();
        imagePreview.classList.remove('hidden');
        imagePlaceholder.classList.add('hidden');
        
        closeCropModal();
    }
</script>
@endpush
