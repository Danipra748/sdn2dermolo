@extends('admin.layout')

@section('title', 'Manajemen PPDB')
@section('heading', 'Manajemen PPDB')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Pengaturan Waktu & Link --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="glass rounded-3xl p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Jadwal & Link PPDB
                </h2>
                
                <form action="{{ route('admin.ppdb.settings.update') }}" method="POST" id="ppdb-settings-form" 
                      data-ppdb-start="{{ $settings->start_date ? $settings->start_date->toIso8601String() : '' }}"
                      data-ppdb-end="{{ $settings->end_date ? $settings->end_date->toIso8601String() : '' }}">
                    @csrf
                    <div class="space-y-4">
                        <div class="p-3 bg-blue-50 border border-blue-100 rounded-xl">
                            <p class="text-xs text-blue-600 font-medium leading-relaxed">
                                <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Status pendaftaran akan berubah secara otomatis berdasarkan waktu yang Anda tentukan di bawah ini.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                            <input type="datetime-local" name="start_date" 
                                   value="{{ $settings->start_date ? $settings->start_date->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                            <input type="datetime-local" name="end_date" 
                                   value="{{ $settings->end_date ? $settings->end_date->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Link Google Form</label>
                            <input type="url" name="form_url" value="{{ $settings->form_url }}" placeholder="https://docs.google.com/forms/d/..."
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="p-5 bg-blue-50 border border-blue-100 rounded-2xl">
                <h3 class="text-sm font-bold text-blue-800 mb-2">Status Saat Ini:</h3>
                <div id="ppdb-admin-status" class="flex items-center gap-2">
                    <div class="animate-pulse flex items-center gap-2 text-slate-400 italic text-xs">
                        <svg class="animate-spin h-3 w-3" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Menghitung status...
                    </div>
                </div>
            </div>
        </div>

        {{-- Banner / Iklan PPDB --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="glass rounded-3xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Banner Info PPDB
                    </h2>
                    <button onclick="toggleModal('modal-add-banner')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Banner
                    </button>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    @forelse($banners as $banner)
                        <div class="relative group rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm">
                            <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-40 object-cover" alt="{{ $banner->title }}">
                            <div class="p-3 flex justify-between items-center">
                                <span class="text-sm font-medium text-slate-700 truncate max-w-[150px]">{{ $banner->title ?? 'Tanpa Judul' }}</span>
                                <div class="flex gap-2">
                                    <button onclick="toggleBannerVisibility({{ $banner->id }})" class="p-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-blue-100 hover:text-blue-600 transition" title="Toggle Aktif">
                                        <svg id="icon-eye-{{ $banner->id }}" class="w-4 h-4 {{ $banner->is_active ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg id="icon-eye-off-{{ $banner->id }}" class="w-4 h-4 {{ $banner->is_active ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                    </button>
                                    <form action="{{ route('admin.ppdb.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if(!$banner->is_active)
                                <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center backdrop-blur-[1px]">
                                    <span class="bg-white/90 px-3 py-1 rounded-full text-xs font-bold text-slate-800">Tidak Aktif</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="sm:col-span-2 py-12 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                            <p class="text-slate-400">Belum ada banner PPDB</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add Banner --}}
    <div id="modal-add-banner" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Tambah Banner PPDB</h3>
            <form action="{{ route('admin.ppdb.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Judul (Opsional)</label>
                        <input type="text" name="title" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Gambar Banner</label>
                        <input type="file" name="image" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                        <input type="number" name="order" value="0" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm outline-none focus:border-blue-500">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="toggleModal('modal-add-banner')" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50 transition">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

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
