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
                <input type="file"
                       id="card_bg_image"
                       name="card_bg_image"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="drop-zone-enabled w-full">
                <p class="mt-1 text-xs text-slate-500">Upload untuk mengganti background. Kosongkan jika tidak ingin mengubah.</p>
                @error('card_bg_image')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                
                @if ($program->card_bg_image)
                    <div class="existing-preview mt-3">
                        <div class="text-xs font-semibold text-slate-700 mb-2">Background Saat Ini:</div>
                        <img src="{{ asset('storage/' . $program->card_bg_image) }}" alt="Background {{ $program->title }}"
                             class="h-24 w-full rounded-xl object-cover border border-slate-200">
                        <form action="{{ route('admin.program-sekolah.card-bg.delete', $program) }}" method="POST" 
                              class="mt-2" onsubmit="return confirm('Hapus background? Anda bisa upload background baru nanti.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700 transition">
                                Hapus Background
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-3 text-xs text-slate-500 italic">Belum ada background. Upload file di atas.</div>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Program</label>
                    <input type="file"
                           id="foto_program"
                           name="foto"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="drop-zone-enabled w-full">
                    <p class="mt-1 text-xs text-slate-500">Upload untuk mengganti foto. Kosongkan jika tidak ingin mengubah.</p>
                    @error('foto')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @if ($program->foto)
                        <div class="existing-preview mt-3">
                            <div class="text-xs font-semibold text-slate-700 mb-2">Foto Saat Ini:</div>
                            <img src="{{ asset('storage/' . $program->foto) }}" alt="{{ $program->title }}"
                                 class="h-20 w-20 rounded-xl object-cover border border-slate-200">
                            <form action="{{ route('admin.program-sekolah.foto.delete', $program) }}" method="POST" 
                                  class="mt-2" onsubmit="return confirm('Hapus foto? Anda bisa upload foto baru nanti.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700 transition">
                                    Hapus Foto
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-3 text-xs text-slate-500 italic">Belum ada foto. Upload file di atas.</div>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Logo Program</label>
                    <input type="file"
                           id="logo_program"
                           name="logo"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="drop-zone-enabled w-full">
                    <p class="mt-1 text-xs text-slate-500">Upload untuk mengganti logo. Kosongkan jika tidak ingin mengubah.</p>
                    @error('logo')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @if ($program->logo)
                        <div class="existing-preview mt-3">
                            <div class="text-xs font-semibold text-slate-700 mb-2">Logo Saat Ini:</div>
                            <img src="{{ asset('storage/' . $program->logo) }}" alt="Logo {{ $program->title }}"
                                 class="h-20 w-20 rounded-full object-cover border border-slate-200">
                            <form action="{{ route('admin.program-sekolah.logo.delete', $program) }}" method="POST" 
                                  class="mt-2" onsubmit="return confirm('Hapus logo? Anda bisa upload logo baru nanti.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs font-semibold hover:bg-red-700 transition">
                                    Hapus Logo
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-3 text-xs text-slate-500 italic">Belum ada logo. Upload file di atas.</div>
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
