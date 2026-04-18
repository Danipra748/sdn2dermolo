@extends('admin.layout')

@section('title', 'Profil Sekolah')
@section('heading', 'Profil Sekolah')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <style>
        .cropper-container { max-height: 450px; }
        #crop-image { max-width: 100%; display: block; }
    </style>
@endpush

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <div class="font-semibold">Error!</div>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.school-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Dasar</h2>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Sekolah</label>
                    <input type="text" name="school_name" value="{{ old('school_name', $profile->school_name) }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('school_name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">NPSN</label>
                    <input type="text" name="npsn" value="{{ old('npsn', $profile->npsn) }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('npsn')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status Sekolah</label>
                    <select name="school_status" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="Negeri" {{ $profile->school_status === 'Negeri' ? 'selected' : '' }}>Negeri</option>
                        <option value="Swasta" {{ $profile->school_status === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Akreditasi</label>
                    <select name="accreditation" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <option value="A" {{ $profile->accreditation === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $profile->accreditation === 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $profile->accreditation === 'C' ? 'selected' : '' }}>C</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Alamat & Lokasi</h2>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('address', $profile->address) }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Desa/Kelurahan</label>
                        <input type="text" name="village" value="{{ old('village', $profile->village) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kecamatan</label>
                        <input type="text" name="district" value="{{ old('district', $profile->district) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kabupaten/Kota</label>
                        <input type="text" name="city" value="{{ old('city', $profile->city) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province', $profile->province) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Kontak & Komunikasi</h2>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                           placeholder="(0291) 123-456"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                           placeholder="sdn2dermolo@gmail.com"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Website</label>
                    <input type="url" name="website" value="{{ old('website', $profile->website) }}"
                           placeholder="https://sdn2dermolo.sch.id"
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
        </div>

        {{-- History & Stats --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Sejarah & Statistik</h2>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Sejarah Sekolah</label>
                    <textarea name="history_content" rows="6" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('history_content', $profile->history_content) }}</textarea>
                    <p class="text-xs text-slate-500 mt-1">Ceritakan sejarah berdirinya sekolah secara singkat dan jelas.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Berdiri</label>
                        <input type="number" name="established_year" value="{{ old('established_year', $profile->established_year) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Luas Tanah</label>
                        <input type="text" name="land_area" value="{{ old('land_area', $profile->land_area) }}"
                               placeholder="1.400 m²"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Kelas</label>
                        <input type="number" name="total_classes" value="{{ old('total_classes', $profile->total_classes) }}"
                               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- Vision & Mission --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Visi & Misi</h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Visi Sekolah</label>
                    <textarea name="vision" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('vision', $profile->vision) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Misi Sekolah</label>
                    <p class="text-xs text-slate-500 mb-3">Isi setiap misi dalam kotak terpisah. Kosongkan jika tidak ada.</p>

                    <div id="missions-container" class="space-y-3">
                        @php
                            $missions = old('mission_items', $profile->missions ?? []);
                            // Ensure we have at least 5 mission slots
                            while (count($missions) < 5) {
                                $missions[] = '';
                            }
                        @endphp

                        @foreach($missions as $index => $mission)
                        <div class="mission-item flex gap-3">
                            <span class="flex items-center justify-center w-8 h-10 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm flex-shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <textarea name="mission_items[{{ $index }}]" rows="2" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ $mission }}</textarea>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addMission()" class="mt-3 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-semibold">
                        <x-heroicon-o-plus class="w-4 h-4" />
                        Tambah Misi
                    </button>
                </div>
            </div>
        </div>

        {{-- Logo Upload Section - ALWAYS VISIBLE --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Logo Sekolah</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload Logo Baru</label>
                    <input type="file" 
                           id="logo-input"
                           name="logo_raw" 
                           accept=".jpg,.jpeg,.png,.webp" 
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    
                    {{-- Hidden inputs for crop data --}}
                    <input type="hidden" name="crop_x" id="crop_x">
                    <input type="hidden" name="crop_y" id="crop_y">
                    <input type="hidden" name="crop_w" id="crop_w">
                    <input type="hidden" name="crop_h" id="crop_h">

                    <p class="mt-2 text-xs text-slate-500">Format: JPG, PNG, WEBP. Rasio 1:1 direkomendasikan. Maksimal 2MB. Kosongkan jika tidak ingin mengganti.</p>
                    
                    @if ($profile->logo)
                        <div class="mt-4">
                            <button type="button" 
                                    onclick="deleteLogo()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Logo Saat Ini
                            </button>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="text-sm font-semibold text-slate-700 mb-2">Preview Logo Saat Ini</div>
                    @if ($profile->logo)
                        <div id="logo-preview-container" class="rounded-2xl overflow-hidden border-2 border-slate-200 shadow-lg bg-white p-4">
                            <img src="{{ asset('storage/' . $profile->logo) }}" 
                                 id="logo-current-preview"
                                 alt="Logo Sekolah" 
                                 class="w-full h-auto max-h-48 object-contain mx-auto">
                        </div>
                        <p class="mt-2 text-xs text-slate-500 text-center">Logo saat ini (dynamic)</p>
                    @else
                        <div id="logo-preview-container" class="w-full h-48 rounded-2xl border-2 border-dashed border-slate-300 flex items-center justify-center text-sm text-slate-400 bg-slate-50">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>Belum ada logo</div>
                                <div class="text-xs mt-1">Upload logo untuk menampilkannya di sini</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Cropping Modal --}}
        <div id="crop-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
            <div class="bg-white rounded-3xl p-6 max-w-2xl w-full shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-slate-900">Crop Logo Sekolah (1:1)</h3>
                    <button type="button" onclick="closeCropModal()" class="text-slate-400 hover:text-slate-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="cropper-container mb-6 bg-slate-100 rounded-xl overflow-hidden flex items-center justify-center">
                    <img id="crop-image" src="" alt="Image to crop">
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

        

        {{-- Actions --}}
        <div class="flex gap-3 pb-8">
            <a href="{{ route('admin.dashboard') }}"
               class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 px-6 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
    let missionCount = {{ count($missions) }};
    let cropper = null;
    const logoInput = document.getElementById('logo-input');
    const cropModal = document.getElementById('crop-modal');
    const cropImage = document.getElementById('crop-image');

    function addMission() {
        missionCount++;
        const container = document.getElementById('missions-container');
        const newMission = document.createElement('div');
        newMission.className = 'mission-item flex gap-3';
        newMission.innerHTML = `
            <span class="flex items-center justify-center w-8 h-10 rounded-lg bg-blue-100 text-blue-600 font-bold text-sm flex-shrink-0">
                ${missionCount}
            </span>
            <textarea name="mission_items[${missionCount - 1}]" rows="2" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Tulis misi ke-${missionCount}..."></textarea>
        `;
        container.appendChild(newMission);
    }

    logoInput.addEventListener('change', function(e) {
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
        
        if (cropper) {
            cropper.destroy();
        }
        
        // Brief timeout to ensure image is loaded in DOM
        setTimeout(() => {
            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
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
        // Reset input if cancelled
        logoInput.value = '';
    }

    function confirmCrop() {
        if (!cropper) return;
        
        const data = cropper.getData();
        document.getElementById('crop_x').value = Math.round(data.x);
        document.getElementById('crop_y').value = Math.round(data.y);
        document.getElementById('crop_w').value = Math.round(data.width);
        document.getElementById('crop_h').value = Math.round(data.height);
        
        // Show preview in UI
        const canvas = cropper.getCroppedCanvas({
            width: 512,
            height: 512
        });
        
        const previewContainer = document.getElementById('logo-preview-container');
        previewContainer.innerHTML = '';
        const previewImg = document.createElement('img');
        previewImg.src = canvas.toDataURL();
        previewImg.className = 'w-full h-auto max-h-48 object-contain mx-auto';
        previewContainer.appendChild(previewImg);
        previewContainer.classList.remove('bg-slate-50', 'border-dashed');
        previewContainer.classList.add('bg-white', 'border-solid');
        
        // Keep modal open or close it? Close it.
        cropModal.classList.add('hidden');
        cropModal.classList.remove('flex');
        // DON'T destroy cropper yet if we need dataURL, but we use coordinates.
    }

    function deleteLogo() {
        if (!confirm('Yakin ingin menghapus logo sekolah?')) return;
        
        fetch("{{ route('admin.school-profile.delete-logo') }}", {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endpush
