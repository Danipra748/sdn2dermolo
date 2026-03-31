@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="glass rounded-3xl p-6 max-w-4xl">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                    @php
                        $slugValue = old('slug', $program->slug);
                    @endphp
                    <select name="slug"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <option value="pramuka" {{ $slugValue === 'pramuka' ? 'selected' : '' }}>pramuka</option>
                        <option value="seni-ukir" {{ $slugValue === 'seni-ukir' ? 'selected' : '' }}>seni-ukir</option>
                        <option value="drumband" {{ $slugValue === 'drumband' ? 'selected' : '' }}>drumband</option>
                    </select>
                    @error('slug')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Program</label>
                    <input type="text" name="title" value="{{ old('title', $program->title) }}"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Program</label>
                <textarea name="desc" rows="4"
                          class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('desc', $program->desc) }}</textarea>
                @error('desc')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Emoji / Inisial</label>
                    <input type="text" name="emoji" value="{{ old('emoji', $program->emoji) }}"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300"
                           placeholder="Contoh: P / U / D">
                    @error('emoji')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Background Card Program</label>
                <input type="file" name="card_bg_image" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('card_bg_image')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @if ($program->card_bg_image)
                    <img src="{{ asset('storage/' . $program->card_bg_image) }}" alt="Background {{ $program->title }}"
                         class="mt-3 h-24 w-full rounded-xl object-cover border border-slate-200">
                    <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="remove_card_bg_image" value="1"
                               class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                        Hapus background saat ini
                    </label>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Program</label>
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('foto')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @if ($program->foto)
                        <img src="{{ asset('storage/' . $program->foto) }}" alt="{{ $program->title }}"
                             class="mt-3 h-20 w-20 rounded-xl object-cover border border-slate-200">
                        <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                            <input type="checkbox" name="remove_foto" value="1"
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                            Hapus foto saat ini
                        </label>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Logo Program</label>
                    <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('logo')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @if ($program->logo)
                        <img src="{{ asset('storage/' . $program->logo) }}" alt="Logo {{ $program->title }}"
                             class="mt-3 h-20 w-20 rounded-full object-cover border border-slate-200">
                        <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                            <input type="checkbox" name="remove_logo" value="1"
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                            Hapus logo saat ini
                        </label>
                    @endif
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.program-sekolah.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
