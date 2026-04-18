@extends('admin.layout')

@php
    $isEdit = isset($fasilitas);
    $title = $isEdit ? 'Edit Fasilitas' : 'Tambah Fasilitas';
@endphp

@section('title', $title)
@section('heading', $title)

@section('content')
    <x-admin.page-header 
        :title="$title"
        subtitle="Kelola detail aset dan sarana prasarana sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1M2.25 15l4.5-2m0 0V3l4.5-1.636M12.75 21V10.75m0 0L21.25 7.5M12.75 10.75V3l4.5-1.636"/></svg>'>
    </x-admin.page-header>
    
    <div class="max-w-4xl mx-auto">
        <form action="{{ $isEdit ? route('admin.fasilitas.update', $fasilitas) : route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit) @method('PUT') @endif
    
            <div class="glass-card p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <x-admin.form-group label="Nama Fasilitas" name="nama" required>
                        <input type="text" name="nama" value="{{ old('nama', $fasilitas->nama ?? '') }}" class="form-input" required>
                    </x-admin.form-group>
                    
                    <x-admin.form-group label="Warna Tema" name="warna">
                        <select name="warna" class="form-input">
                            @foreach (['blue', 'green', 'yellow', 'pink', 'purple', 'orange'] as $color)
                                <option value="{{ $color }}" @selected(old('warna', $fasilitas->warna ?? 'blue') == $color)>
                                    {{ ucfirst($color) }}
                                </option>
                            @endforeach
                        </select>
                    </x-admin.form-group>
                </div>
    
                <x-admin.form-group label="Deskripsi Singkat" name="deskripsi" class="mt-6">
                    <textarea name="deskripsi" rows="3" class="form-input">{{ old('deskripsi', $fasilitas->deskripsi ?? '') }}</textarea>
                </x-admin.form-group>
            </div>
    
            <div class="glass-card p-6">
                <h3 class="font-bold text-slate-900 mb-4">Gambar</h3>
                <x-admin.form-group label="Foto Utama" name="foto" help="Gambar utama yang mewakili fasilitas. Rasio 16:9 disarankan.">
                    <input type="file" name="foto" class="file-input">
                </x-admin.form-group>
    
                @if ($isEdit && $fasilitas->foto)
                    <div class="mt-2">
                        <label class="inline-flex items-center gap-2 text-xs">
                            <input type="checkbox" name="remove_foto" value="1" class="rounded"> Hapus foto saat ini
                        </label>
                    </div>
                @endif
            </div>

            <div class="lg:flex items-center gap-3 mt-8">
                <x-admin.button href="{{ route('admin.fasilitas.index') }}" variant="secondary">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Buat Fasilitas' }}</x-admin.button>
            </div>
        </form>
    </div>
@endsection
