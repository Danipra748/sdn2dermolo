@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="glass rounded-3xl p-6 max-w-3xl">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Fasilitas</label>
                <input type="text" name="nama" value="{{ old('nama', $fasilitas->nama) }}"
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('nama')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Icon (emoji)</label>
                    <input type="text" name="icon" maxlength="10" value="{{ old('icon', $fasilitas->icon ?: '🏫') }}"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('icon')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Icon (gambar)</label>
                    <input type="file" name="icon_image" accept=".jpg,.jpeg,.png,.webp"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('icon_image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @if ($fasilitas->icon_image)
                        <img src="{{ asset('storage/' . $fasilitas->icon_image) }}" alt="{{ $fasilitas->nama }}"
                             class="mt-3 h-16 w-16 rounded-xl object-cover border border-slate-200">
                        <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                            <input type="checkbox" name="remove_icon_image" value="1"
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                            Hapus icon saat ini
                        </label>
                    @endif
                </div>

            

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Warna</label>
                    <select name="warna"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                        @php
                            $current = old('warna', $fasilitas->warna ?: 'blue');
                            $warnaList = ['blue', 'green', 'yellow', 'pink', 'purple', 'orange'];
                        @endphp
                        @foreach ($warnaList as $warna)
                            <option value="{{ $warna }}" {{ $current === $warna ? 'selected' : '' }}>
                                {{ ucfirst($warna) }}
                            </option>
                        @endforeach
                    </select>
                    @error('warna')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1 gap-3">
                    <label class="block text-sm font-medium text-slate-700">Konten Detail Fasilitas (JSON)</label>
                    <button type="button" id="btn-template-konten"
                            class="px-3 py-1 rounded-xl border border-slate-300 text-xs text-slate-700 hover:bg-slate-50 transition">
                        Isi Template
                    </button>
                </div>
                <textarea name="konten" id="konten-json" rows="18"
                          class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('konten', $kontenValue ?? '') }}</textarea>
                <p class="text-xs text-slate-500 mt-2">
                    Bagian ini mengatur isi detail halaman fasilitas: kapasitas, program, tata tertib, CTA, dan section lainnya.
                    Gunakan format JSON object.
                </p>
                @error('konten')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.fasilitas.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('btn-template-konten');
            const textarea = document.getElementById('konten-json');
            const namaInput = document.querySelector('input[name="nama"]');
            const template = @json($kontenTemplate ?? '{}');
            const templateMap = @json($kontenTemplates ?? []);

            if (!button || !textarea) return;

            button.addEventListener('click', function () {
                const current = (textarea.value || '').trim();
                if (current !== '' && !confirm('Konten JSON saat ini akan diganti dengan template. Lanjutkan?')) {
                    return;
                }
                const nama = (namaInput?.value || '').trim();
                textarea.value = templateMap[nama] ?? template;
            });
        });
    </script>
@endsection
