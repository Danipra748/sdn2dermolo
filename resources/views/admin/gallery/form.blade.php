@extends('admin.layout')

@php
    $isEdit = isset($gallery) && $gallery->id;
    $title = $isEdit ? 'Edit Foto Galeri' : 'Upload Foto Baru';
@endphp

@section('title', $title)
@section('heading', $title)

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Upload dan kelola foto untuk galeri sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/><path d="M8.25 8.25h.008v.008H8.25V8.25z"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $isEdit ? route('admin.gallery.update', $gallery) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6 space-y-6">
                <x-admin.form-group label="Judul Foto" name="title" required>
                    <input type="text" name="title" value="{{ old('title', $gallery->title ?? '') }}" class="form-input" required>
                </x-admin.form-group>
                
                <x-admin.form-group label="Deskripsi (Opsional)" name="description">
                    <textarea name="description" rows="3" class="form-input">{{ old('description', $gallery->description ?? '') }}</textarea>
                </x-admin.form-group>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">File Gambar</h3>
                <x-admin.form-group label="Upload Foto" name="foto" :required="!$isEdit">
                    <input type="file" name="foto" class="file-input">
                </x-admin.form-group>
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.gallery.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Upload Foto' }}</x-admin.button>
            </div>
        </form>
    </div>
@endsection
