@extends('admin.layout')

@section('title', 'Hidden Settings')
@section('heading', 'Hidden Settings')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
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

    <div class="grid gap-6">
        <section id="sambutan-settings" class="glass rounded-3xl p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Sambutan Kepala Sekolah Tersembunyi</h2>
                <p class="text-sm text-slate-500">Form sambutan dipindahkan ke halaman rahasia agar dashboard utama tetap bersih.</p>
            </div>

            <form action="{{ route('admin.sambutan-kepsek.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Foto Kepala Sekolah (Sambutan)</label>
                        <input type="file"
                               name="foto"
                               accept=".jpg,.jpeg,.png,.webp"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">

                        @if (! empty($sambutanFoto))
                            <img src="{{ asset('storage/' . $sambutanFoto) }}"
                                 alt="Foto Kepala Sekolah"
                                 class="mt-4 w-full max-w-xs aspect-[4/3] rounded-3xl object-cover border border-slate-200">

                            <label class="mt-3 inline-flex items-center gap-2 text-xs text-slate-600">
                                <input type="checkbox" name="remove_foto" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                                Hapus foto saat ini
                            </label>
                        @else
                            <div class="mt-4 w-full max-w-xs aspect-[4/3] rounded-3xl border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-500">
                                Belum ada foto sambutan
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Teks Sambutan Kepala Sekolah</label>
                        {{-- Di sini variabel sambutan kepala sekolah diproses. --}}
                        <textarea name="sambutan"
                                  rows="12"
                                  class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">{{ old('sambutan', $sambutanText) }}</textarea>
                        <p class="mt-2 text-xs text-slate-500">Teks ini tetap dipakai di halaman publik seperti sebelumnya.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                        Simpan Sambutan
                    </button>
                </div>
            </form>
        </section>

        <section id="foto-kepsek-settings" class="glass rounded-3xl p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Foto Resmi Kepala Sekolah (Halaman Tentang Kami)</h2>
                <p class="text-sm text-slate-500">Foto ini akan ditampilkan di halaman "Tentang Kami" pada bagian sambutan.</p>
            </div>

            <form action="{{ route('admin.settings.upload-foto-kepsek') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Upload Foto Kepala Sekolah</label>
                        <input type="file"
                               name="foto_kepsek"
                               accept=".jpg,.jpeg,.png,.webp"
                               onchange="previewFotoKepsek(event)"
                               class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        <p class="mt-2 text-xs text-slate-500">Format: JPG, PNG, WebP. Maksimal 3MB. Rasio 4:5 disarankan.</p>
                    </div>

                    <div>
                        <div class="text-sm font-semibold text-slate-700 mb-2">Preview Foto Saat Ini</div>
                        @if (!empty($fotoKepsek))
                            <div class="rounded-2xl overflow-hidden border-2 border-slate-200 shadow-lg">
                                <img id="current-foto-kepsek" src="{{ asset('storage/' . $fotoKepsek) }}" alt="Foto Kepala Sekolah" class="w-full aspect-[4/5] object-cover">
                            </div>
                            <div class="mt-3">
                                <form action="{{ route('admin.settings.delete-foto-kepsek') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto kepala sekolah?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                                        Hapus Foto
                                    </button>
                                </form>
                            </div>
                        @else
                            <div id="foto-kepsek-placeholder" class="w-full aspect-[4/5] rounded-2xl border-2 border-dashed border-slate-300 flex items-center justify-center text-sm text-slate-400 bg-slate-50">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <div>Belum ada foto</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div id="foto-kepsek-preview" class="hidden rounded-2xl bg-blue-50 border border-blue-200 p-5">
                    <div class="text-sm font-semibold text-blue-900">Preview Foto Baru</div>
                    <img id="foto-kepsek-preview-image" src="" alt="Preview foto kepala sekolah" class="mt-4 w-full max-w-xs aspect-[4/5] rounded-2xl object-cover border border-slate-200 shadow-sm">
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-2xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload Foto Kepala Sekolah
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    function previewFotoKepsek(event) {
        const file = event.target.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('foto-kepsek-preview');
            const previewImage = document.getElementById('foto-kepsek-preview-image');

            previewImage.src = e.target.result;
            preview.classList.remove('hidden');

            const placeholder = document.getElementById('foto-kepsek-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };

        reader.readAsDataURL(file);
    }
</script>
@endpush
