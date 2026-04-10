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
        <section id="logo-settings" class="glass rounded-3xl p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Upload Logo Tersembunyi</h2>
                <p class="text-sm text-slate-500">Form ini dipindahkan dari halaman umum admin agar tidak tampil saat presentasi.</p>
            </div>

            {{-- Di sini lokasi penyimpanan path logonya. --}}
            <div class="mb-6 rounded-2xl bg-slate-50 border border-slate-200 p-5">
                <div class="text-sm font-semibold text-slate-800">Preview Logo Saat Ini</div>
                <div class="mt-4 flex flex-col gap-4 md:flex-row md:items-center">
                    <div class="flex h-32 w-32 items-center justify-center rounded-2xl bg-white border border-slate-200 p-4 shadow-sm">
                        @if ($logoExists && $logoPublicPath)
                            <img src="{{ asset($logoPublicPath) }}" alt="Logo SD N 2 Dermolo" class="h-full w-full object-contain">
                        @else
                            <div class="text-center text-slate-400 text-xs">
                                Belum ada logo
                            </div>
                        @endif
                    </div>
                    <div class="text-sm text-slate-600">
                        <div class="font-medium text-slate-800">Path aktif</div>
                        <div class="mt-1 break-all">{{ $logoStoragePath ?? 'Belum ada file logo tersimpan.' }}</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.settings.upload-logo') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Upload Logo Baru</label>
                    <input type="file"
                           name="logo"
                           accept=".png,.jpg,.jpeg,.webp,.svg"
                           onchange="previewHiddenLogo(event)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <p class="mt-2 text-xs text-slate-500">Format yang didukung: PNG, JPG, JPEG, WEBP, SVG. Maksimal 5MB.</p>
                </div>

                <div id="hidden-logo-preview" class="hidden rounded-2xl bg-blue-50 border border-blue-200 p-5">
                    <div class="text-sm font-semibold text-blue-900">Preview Logo Baru</div>
                    <img id="hidden-logo-preview-image" src="" alt="Preview logo baru" class="mt-4 h-32 w-32 rounded-2xl bg-white border border-slate-200 p-4 object-contain shadow-sm">
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                            class="px-5 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition">
                        Simpan Logo
                    </button>
                </div>
            </form>
        </section>

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
                        <label class="block text-sm font-medium text-slate-700 mb-2">Foto Kepala Sekolah</label>
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
    </div>
@endsection

@push('scripts')
<script>
    function previewHiddenLogo(event) {
        const file = event.target.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('hidden-logo-preview');
            const previewImage = document.getElementById('hidden-logo-preview-image');

            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }
</script>
@endpush
