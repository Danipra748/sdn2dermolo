@extends('admin.layout')

@php
    $isEdit = isset($banner) && $banner->id;
    $title = $isEdit ? 'Edit Banner' : 'Tambah Banner';
@endphp

@section('title', $title)
@section('heading', $title)

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Kelola banner promosi untuk halaman PPDB."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $isEdit ? route('admin.ppdb.banners.update', $banner) : route('admin.ppdb.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6 space-y-6">
                <x-admin.form-group label="Judul Banner" name="title">
                    <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}" class="form-input">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </x-admin.form-group>
                
                <x-admin.form-group label="Urutan Tampil" name="order">
                    <input type="number" name="order" value="{{ old('order', $banner->order ?? '1') }}" class="form-input w-24">
                    @error('order')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </x-admin.form-group>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">File Gambar</h3>
                <x-admin.form-group label="Upload Gambar Banner" name="image" :required="!$isEdit" help="Ukuran gambar bebas, rasio 16:9 atau 2:1 disarankan.">
                    <input type="file" name="image" class="file-input">
                    @error('image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </x-admin.form-group>
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.ppdb.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Banner' }}</x-admin.button>
            </div>
        </form>
    </div>
@endsection
