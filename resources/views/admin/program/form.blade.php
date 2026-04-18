@extends('admin.layout')

@php
    $isEdit = isset($program) && $program->id;
    $title = $isEdit ? 'Edit Program' : 'Tambah Program';
@endphp

@section('title', $title)
@section('heading', $title)

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Kelola program unggulan dan kegiatan ekstrakurikuler."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $isEdit ? route('admin.program-sekolah.update', $program) : route('admin.program-sekolah.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6 space-y-6">
                <x-admin.form-group label="Nama Program/Ekstrakurikuler" name="title" required>
                    <input type="text" name="title" value="{{ old('title', $program->title ?? '') }}" class="form-input" required>
                </x-admin.form-group>
                
                <x-admin.form-group label="Deskripsi Singkat" name="description">
                    <textarea name="description" rows="4" class="form-input">{{ old('description', $program->description ?? '') }}</textarea>
                </x-admin.form-group>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">Pengaturan Tampilan</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <label for="is_active" class="flex items-center gap-2 text-sm font-medium text-slate-700">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $program->is_active ?? true)) class="rounded">
                            Aktifkan program ini
                        </label>
                        <label for="is_highlight" class="flex items-center gap-2 text-sm font-medium text-slate-700">
                             <input type="hidden" name="is_highlight" value="0">
                            <input type="checkbox" name="is_highlight" value="1" @checked(old('is_highlight', $program->is_highlight ?? false)) class="rounded">
                            Jadikan Highlight
                        </label>
                    </div>
                    <x-admin.form-group label="Gambar Logo (Opsional)" name="logo">
                        <input type="file" name="logo" class="file-input">
                    </x-admin.form-group>
                </div>
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.program-sekolah.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Buat Program' }}</x-admin.button>
            </div>
        </form>
    </div>
@endsection
