@extends('admin.layout')

@section('title', 'Sambutan Kepala Sekolah')
@section('heading', 'Sambutan Kepala Sekolah')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6 max-w-4xl">
        <form action="{{ route('admin.sambutan-kepsek.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Kepala Sekolah</label>
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('foto')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    @if (!empty($sambutanFoto))
                        <img src="{{ asset('storage/' . $sambutanFoto) }}" alt="Foto Kepala Sekolah"
                             class="mt-4 w-full max-w-xs aspect-[4/3] rounded-3xl object-cover border border-slate-200">
                        <label class="mt-3 inline-flex items-center gap-2 text-xs text-slate-600">
                            <input type="checkbox" name="remove_foto" value="1"
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                            Hapus foto saat ini
                        </label>
                    @else
                        <div class="mt-4 w-full max-w-xs aspect-[4/3] rounded-3xl border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-500">
                            Belum ada foto
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sambutan Kepala Sekolah</label>
                    <textarea name="sambutan" rows="12"
                              class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('sambutan', $sambutanText) }}</textarea>
                    @error('sambutan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-500">Gunakan baris baru untuk membuat paragraf.</p>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
