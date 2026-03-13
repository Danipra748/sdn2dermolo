@extends('admin.layout')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('heading', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="POST" class="glass rounded-3xl p-6 space-y-4 max-w-2xl">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div>
            <label class="text-sm font-semibold text-slate-700">Nama</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
        </div>
        <div>
            <label class="text-sm font-semibold text-slate-700">Deskripsi</label>
            <textarea name="description" rows="4"
                class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.categories.index') }}"
                class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                Kembali
            </a>
            <button type="submit"
                class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                Simpan
            </button>
        </div>
    </form>
@endsection
