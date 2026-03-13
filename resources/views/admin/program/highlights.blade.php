@extends('admin.layout')

@section('title', 'Highlight Program')
@section('heading', 'Highlight Program')

@section('content')
    <div class="glass rounded-3xl p-6 max-w-4xl">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">{{ $program->title }}</h2>
            <p class="text-sm text-slate-500">Atur poin highlight untuk program ini.</p>
        </div>

        <form action="{{ $action }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Poin 1</label>
                    <textarea name="highlight_1" rows="4"
                              class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('highlight_1', $program->highlight_1) }}</textarea>
                    @error('highlight_1')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Poin 2</label>
                    <textarea name="highlight_2" rows="4"
                              class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('highlight_2', $program->highlight_2) }}</textarea>
                    @error('highlight_2')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Poin 3</label>
                    <textarea name="highlight_3" rows="4"
                              class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('highlight_3', $program->highlight_3) }}</textarea>
                    @error('highlight_3')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan Highlight
                </button>
                <a href="{{ route('admin.program-sekolah.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
