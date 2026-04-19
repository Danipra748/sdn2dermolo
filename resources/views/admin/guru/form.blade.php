@extends('admin.layout')

@php
    $isEdit = isset($guru) && $guru->id;
    $title = $isEdit ? 'Edit Guru' : 'Tambah Guru';
@endphp

@section('title', $title)
@section('heading', $title)

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Kelola profil guru dan staf administrasi sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $isEdit ? route('admin.guru.update', $guru) : route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <x-admin.form-group label="Nama Lengkap" name="nama" required>
                        <input type="text" name="nama" value="{{ old('nama', $guru->nama ?? '') }}" class="form-input" required>
                    </x-admin.form-group>
                    
                    <x-admin.form-group label="Jabatan" name="jabatan" required>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan ?? '') }}" class="form-input" required>
                    </x-admin.form-group>
                </div>
    
                <x-admin.form-group label="No. Urut Tampil" name="no" class="mt-6">
                    <input type="number" name="no" value="{{ old('no', $guru->no ?? '99') }}" class="form-input w-24">
                </x-admin.form-group>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">Foto Profil</h3>
                <x-admin.form-group label="Upload Foto" name="photo" help="Rasio 1:1 (persegi) disarankan.">
                    <input type="file" name="photo" class="file-input">
                </x-admin.form-group>
    
                @if ($isEdit && $guru->photo)
                    <div class="mt-2">
                        <label class="inline-flex items-center gap-2 text-xs">
                            <input type="checkbox" name="remove_photo" value="1" class="rounded"> Hapus foto saat ini
                        </label>
                    </div>
                @endif
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.guru.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Guru' }}</x-admin.button>
            </div>
        </form>
    </div>
@endsection
