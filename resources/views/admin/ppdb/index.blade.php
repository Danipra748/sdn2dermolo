@extends('admin.layout')

@section('title', 'Pengaturan PPDB')
@section('heading', 'Manajemen PPDB')

@section('content')
    <x-admin.page-header 
        title="Pengaturan Penerimaan Peserta Didik Baru (PPDB)"
        subtitle="Atur jadwal, status pendaftaran, dan kelola banner promosi PPDB di sini."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

        <div class="grid lg:grid-cols-3 gap-8">
        {{-- Settings Form --}}
        <div class="lg:col-span-1">
            <form action="{{ route('admin.ppdb.settings.update') }}" method="POST" class="glass-card p-6 space-y-4">
                @csrf
                @method('PUT')
                <h3 class="text-lg font-bold">Jadwal Pendaftaran</h3>
                <x-admin.form-group label="Tanggal Mulai" name="start_date" required>
                    <input type="date" name="start_date" value="{{ old('start_date', $settings->start_date?->format('Y-m-d')) }}" class="w-full form-input" required>
                </x-admin.form-group>
                <x-admin.form-group label="Tanggal Selesai" name="end_date" required>
                    <input type="date" name="end_date" value="{{ old('end_date', $settings->end_date?->format('Y-m-d')) }}" class="w-full form-input" required>
                </x-admin.form-group>
                <x-admin.form-group label="Link Pendaftaran" name="registration_link" help="URL formulir pendaftaran (misal: Google Form).">
                    <input type="url" name="registration_link" value="{{ old('registration_link', $settings->registration_link) }}" class="w-full form-input" placeholder="https://">
                </x-admin.form-group>
                <div class="pt-2">
                    <x-admin.button type="submit" variant="primary" size="md" class="w-full">Simpan Jadwal</x-admin.button>
                </div>
            </form>
        </div>

        {{-- Banners Table --}}
        <div class="lg:col-span-2">
             <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold">Banner Promosi</h3>
                 <x-admin.button href="{{ route('admin.ppdb.banners.create') }}" variant="primary" size="sm">
                    <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg></x-slot:icon>
                    Tambah Banner
                </x-admin.button>
            </div>
            <x-admin.data-table
                :headers="['Gambar', 'Judul', 'Urutan', 'Aksi']"
                searchPlaceholder="Cari banner...">
                @forelse($banners as $banner)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="w-24 h-12 rounded-lg bg-slate-100 overflow-hidden border border-slate-200">
                                <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $banner->title }}</td>
                        <td class="px-6 py-4 font-bold text-slate-500">{{ $banner->order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button variant="secondary" size="sm" href="{{ route('admin.ppdb.banners.edit', $banner) }}">Edit</x-admin.button>
                                <form action="{{ route('admin.ppdb.banners.destroy', $banner) }}" method="POST" data-confirm="Yakin ingin menghapus banner ini?">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="destructive" size="sm">Hapus</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center text-slate-400 italic">Belum ada banner promosi.</td>
                    </tr>
                @endforelse
            </x-admin.data-table>
        </div>
    </div>
@endsection
