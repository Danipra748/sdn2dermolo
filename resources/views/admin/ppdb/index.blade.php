@extends('admin.layout')

@section('title', 'Manajemen PPDB')
@section('heading', 'Manajemen PPDB')

@push('styles')
    {{-- Flatpickr for better date/time picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .flatpickr-input {
            background-color: #ffffff !important;
        }
    </style>
@endpush

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 px-6 py-4 text-sm text-emerald-800 flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-6 py-4 text-sm text-red-800 shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="font-medium">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid lg:grid-cols-12 gap-8">
        {{-- Pengaturan Waktu & Link (Side) --}}
        <div class="lg:col-span-4 space-y-8">
            <div class="modern-card p-8">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    Jadwal & Link
                </h2>
                
                <form action="{{ route('admin.ppdb.settings.update') }}" method="POST" id="ppdb-settings-form" 
                      data-ppdb-start="{{ $settings->start_date ? $settings->start_date->toIso8601String() : '' }}"
                      data-ppdb-end="{{ $settings->end_date ? $settings->end_date->toIso8601String() : '' }}">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label class="form-label font-bold text-slate-700">Tanggal Mulai</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <input type="text" name="start_date" id="start_date" 
                                       value="{{ $settings->start_date ? $settings->start_date->format('Y-m-d H:i') : '' }}"
                                       class="form-input pl-10 cursor-pointer" placeholder="Pilih tanggal mulai...">
                            </div>
                        </div>

                        <div>
                            <label class="form-label font-bold text-slate-700">Tanggal Selesai</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <input type="text" name="end_date" id="end_date" 
                                       value="{{ $settings->end_date ? $settings->end_date->format('Y-m-d H:i') : '' }}"
                                       class="form-input pl-10 cursor-pointer" placeholder="Pilih tanggal selesai...">
                            </div>
                        </div>

                        <div>
                            <label class="form-label font-bold text-slate-700">Link Google Form</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.828a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                </span>
                                <input type="url" name="form_url" value="{{ $settings->form_url }}" 
                                       class="form-input pl-10" placeholder="https://docs.google.com/forms/d/...">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 active:scale-[0.98] mt-4">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                <h3 class="text-sm font-bold text-blue-100 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="flex h-2 w-2 rounded-full bg-white animate-ping"></span>
                    Live Status
                </h3>
                <div id="ppdb-admin-status" class="flex flex-col gap-2">
                    <div class="text-2xl font-black">Memuat status...</div>
                </div>
            </div>
        </div>

        {{-- Banner / Iklan PPDB (Main) --}}
        <div class="lg:col-span-8 space-y-8">
            <div class="modern-card p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            Banner Promosi PPDB
                        </h2>
                        <p class="text-slate-500 text-sm mt-1">Kelola banner yang akan tampil di halaman utama PPDB</p>
                    </div>
                    <button onclick="toggleModal('modal-add-banner')" class="inline-flex items-center gap-2.5 px-6 py-3.5 bg-blue-600 text-white rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Banner Baru
                    </button>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    @forelse($banners as $banner)
                        <div class="group relative rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                            <div class="relative aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $banner->title }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            
                            <div class="p-5 flex flex-col gap-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Banner #{{ $banner->order }}</span>
                                        <h3 class="text-base font-bold text-slate-800 line-clamp-1">{{ $banner->title ?? 'Tanpa Judul' }}</h3>
                                    </div>
                                    <div class="flex gap-1.5">
                                        <button onclick="editBanner({{ json_encode($banner) }})" 
                                            class="p-2.5 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-100 transition shadow-sm" 
                                            title="Edit Banner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="toggleBannerVisibility({{ $banner->id }})" 
                                                class="p-2.5 rounded-xl {{ $banner->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }} hover:bg-blue-50 hover:text-blue-600 transition shadow-sm" 
                                                title="{{ $banner->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                            <svg id="icon-eye-{{ $banner->id }}" class="w-5 h-5 {{ $banner->is_active ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg id="icon-eye-off-{{ $banner->id }}" class="w-5 h-5 {{ $banner->is_active ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        </button>
                                        <form action="{{ route('admin.ppdb.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if(!$banner->is_active)
                                <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur text-white px-3 py-1 rounded-lg text-[10px] font-black tracking-widest uppercase">Draft</div>
                            @endif
                        </div>
                    @empty
                        <div class="sm:col-span-2 flex flex-col items-center justify-center py-20 bg-slate-50 rounded-3xl border-4 border-dashed border-slate-200 text-slate-400">
                            <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="font-bold">Belum ada banner promosi</p>
                            <button onclick="toggleModal('modal-add-banner')" class="mt-4 text-blue-600 font-bold hover:underline">Klik untuk menambah</button>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add Banner --}}
    <div id="modal-add-banner" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] p-8 max-w-md w-full shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-cyan-500"></div>
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-900">Tambah Banner PPDB</h3>
                <button type="button" onclick="toggleModal('modal-add-banner')" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.ppdb.banners.store') }}" method="POST" enctype="multipart/form-data" id="banner-form">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="form-label font-bold text-slate-700">Judul Banner (Opsional)</label>
                        <input type="text" name="title" class="form-input" placeholder="Masukkan judul menarik...">
                    </div>
                    
                    <div id="drop-zone" class="relative group cursor-pointer">
                        <label class="form-label font-bold text-slate-700">Gambar Banner</label>
                        <div class="mt-1 border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center bg-slate-50 transition hover:bg-blue-50 hover:border-blue-300 group-active:scale-[0.98]">
                            <div id="preview-container" class="hidden mb-4">
                                <img id="banner-preview" class="max-h-40 mx-auto rounded-xl shadow-md">
                            </div>
                            <div id="upload-instruction">
                                <svg class="w-10 h-10 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Klik atau Seret Gambar</p>
                                <p class="text-[10px] text-slate-400 mt-1">JPG, PNG, WEBP (Maks. 2MB)</p>
                            </div>
                            <input type="file" name="image" id="banner-input" required class="hidden" accept="image/*">
                        </div>
                    </div>

                    <div>
                        <label class="form-label font-bold text-slate-700">Urutan Tampilan</label>
                        <input type="number" name="order" value="0" class="form-input" placeholder="0">
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="toggleModal('modal-add-banner')" class="flex-1 px-4 py-4 rounded-xl border-2 border-slate-100 text-slate-500 font-bold hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-4 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Modal Edit Banner --}}
    <div id="modal-edit-banner" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] p-8 max-w-md w-full shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black text-slate-900">Edit Banner PPDB</h3>
                <button type="button" onclick="toggleModal('modal-edit-banner')" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" id="edit-banner-form">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="form-label font-bold text-slate-700">Judul Banner (Opsional)</label>
                        <input type="text" name="title" id="edit-banner-title" class="form-input" placeholder="Masukkan judul menarik...">
                    </div>
                    
                    <div id="edit-drop-zone" class="relative group cursor-pointer">
                        <label class="form-label font-bold text-slate-700">Ganti Gambar (Opsional)</label>
                        <div class="mt-1 border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center bg-slate-50 transition hover:bg-amber-50 hover:border-amber-300 group-active:scale-[0.98]">
                            <div id="edit-preview-container" class="mb-4">
                                <img id="edit-banner-preview" class="max-h-40 mx-auto rounded-xl shadow-md">
                            </div>
                            <div id="edit-upload-instruction">
                                <svg class="w-10 h-10 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Klik untuk Ganti Gambar</p>
                            </div>
                            <input type="file" name="image" id="edit-banner-input" class="hidden" accept="image/*">
                        </div>
                    </div>

                    <div>
                        <label class="form-label font-bold text-slate-700">Urutan Tampilan</label>
                        <input type="number" name="order" id="edit-banner-order" class="form-input" placeholder="0">
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="toggleModal('modal-edit-banner')" class="flex-1 px-4 py-4 rounded-xl border-2 border-slate-100 text-slate-500 font-bold hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-4 rounded-xl bg-amber-500 text-white font-bold hover:bg-amber-600 transition shadow-lg shadow-amber-600/20">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Flatpickr JS --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr for Start Date
        const startPicker = flatpickr("#start_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            locale: "id",
            time_24hr: true,
            minDate: "today",
            onChange: function(selectedDates, dateStr) {
                endPicker.set('minDate', dateStr);
            }
        });

        // Initialize Flatpickr for End Date
        const endPicker = flatpickr("#end_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            locale: "id",
            time_24hr: true,
            minDate: "{{ $settings->start_date ? $settings->start_date->format('Y-m-d H:i') : 'today' }}"
        });

        // Banner Image Preview Logic
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('banner-input');
        const preview = document.getElementById('banner-preview');
        const previewContainer = document.getElementById('preview-container');
        const uploadInstruction = document.getElementById('upload-instruction');

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    uploadInstruction.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // SPA-like Status update loop for Admin
        setInterval(() => {
            const container = document.getElementById('ppdb-settings-form');
            const statusEl = document.getElementById('ppdb-admin-status');
            if (!container || !statusEl) return;

            const now = new Date().getTime();
            const startStr = container.dataset.ppdbStart;
            const endStr = container.dataset.ppdbEnd;

            if (!startStr || !endStr) {
                statusEl.innerHTML = '<div class="text-xl font-black">BELUM DIATUR</div><div class="text-xs text-blue-200 uppercase tracking-widest font-bold mt-1">Silakan tentukan jadwal</div>';
                return;
            }

            const start = new Date(startStr).getTime();
            const end = new Date(endStr).getTime();

            let statusText = '';
            let subtitle = '';
            
            if (now < start) {
                statusText = 'MENUNGGU';
                subtitle = 'Pendaftaran belum dimulai';
            } else if (now > end) {
                statusText = 'DITUTUP';
                subtitle = 'Masa pendaftaran berakhir';
            } else {
                const diffHours = (end - now) / (1000 * 60 * 60);
                if (diffHours <= 24) {
                    statusText = 'HAMPIR SELESAI';
                    subtitle = `Berakhir dalam ${Math.floor(diffHours)} jam lagi`;
                } else {
                    statusText = 'BERJALAN';
                    subtitle = 'Pendaftaran sedang dibuka';
                }
            }

            statusEl.innerHTML = `<div class="text-3xl font-black tracking-tighter">${statusText}</div><div class="text-xs text-blue-100 font-bold opacity-80 uppercase tracking-widest mt-1">${subtitle}</div>`;
        }, 1000);
    });

    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    function editBanner(banner) {
        const form = document.getElementById('edit-banner-form');
        form.action = `{{ url('admin/ppdb/banners') }}/${banner.id}`;
        
        document.getElementById('edit-banner-title').value = banner.title || '';
        document.getElementById('edit-banner-order').value = banner.order || 0;
        
        // Show current image in preview
        const preview = document.getElementById('edit-banner-preview');
        const previewContainer = document.getElementById('edit-preview-container');
        const uploadInstruction = document.getElementById('edit-upload-instruction');
        
        preview.src = `{{ asset('storage') }}/${banner.image_path}`;
        previewContainer.classList.remove('hidden');
        uploadInstruction.classList.add('hidden');
        
        toggleModal('modal-edit-banner');
    }

    // Edit Modal Image Preview Logic
    const editDropZone = document.getElementById('edit-drop-zone');
    const editFileInput = document.getElementById('edit-banner-input');
    
    editDropZone?.addEventListener('click', () => editFileInput.click());
    
    editFileInput?.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit-banner-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    function toggleBannerVisibility(id) {
        fetch(`{{ url('admin/ppdb/banners') }}/${id}/toggle`, {
            method: 'PATCH',
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
