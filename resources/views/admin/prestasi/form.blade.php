@extends('admin.layout')

@php
    $isEdit = $prestasi->exists;
    $title = $isEdit ? 'Edit Prestasi' : 'Tambah Prestasi';
@endphp

@section('title', $title)
@section('heading', $title)

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Masukkan data pencapaian dan prestasi siswa atau sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12.75L11.25 15 15 9.75M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6 space-y-6">
                <x-admin.form-group label="Judul Prestasi" name="title" required>
                    <input type="text" name="title" value="{{ old('title', $prestasi->title ?? '') }}" class="form-input" required>
                </x-admin.form-group>
                
                <x-admin.form-group label="Nama Peserta/Tim" name="participant" required>
                    <input type="text" name="participant" value="{{ old('participant', $prestasi->participant ?? '') }}" class="form-input" required>
                </x-admin.form-group>

                <div class="grid md:grid-cols-2 gap-6">
                    <x-admin.form-group label="Tipe Prestasi" name="type" required>
                        <select name="type" class="form-input">
                            <option value="Akademik" @selected(old('type', $prestasi->type ?? '') == 'Akademik')>Akademik</option>
                            <option value="Non-Akademik" @selected(old('type', $prestasi->type ?? '') == 'Non-Akademik')>Non-Akademik</option>
                        </select>
                    </x-admin.form-group>
                    <x-admin.form-group label="Tingkat" name="level" required>
                        <select name="level" class="form-input">
                            @foreach(['Sekolah', 'Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional'] as $level)
                                <option value="{{ $level }}" @selected(old('level', $prestasi->level ?? '') == $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                    </x-admin.form-group>
                </div>

                 <x-admin.form-group label="Tanggal Diraih" name="date" required>
                    <input type="date" name="date" value="{{ old('date', $prestasi->date ?? now()->format('Y-m-d')) }}" class="form-input">
                </x-admin.form-group>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">Dokumentasi</h3>
                <x-admin.form-group label="Foto Piagam/Piala" name="foto">
                    <input type="file" name="foto" class="file-input">
                </x-admin.form-group>
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.prestasi-sekolah.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Prestasi' }}</x-admin.button>
            </div>
        </form>
    </div>
@endsection
