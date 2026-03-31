@extends('admin.layout')

@section('title', 'Kontak Sekolah')
@section('heading', 'Kontak Sekolah')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Kontak</h2>
            <p class="text-sm text-slate-500">Isi alamat, telepon, email, dan tautan Google Maps agar tampil di beranda.</p>
        </div>

        <form action="{{ route('admin.kontak.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Sekolah</label>
                <textarea name="address" rows="4"
                          class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300"
                          placeholder="Contoh: Desa Dermolo, Kecamatan Kembang&#10;Kabupaten Jepara, Jawa Tengah">{{ old('address', $kontak['address'] ?? '') }}</textarea>
                @error('address')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $kontak['phone'] ?? '') }}"
                           placeholder="Contoh: (0291) 123-456"
                           class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email Sekolah</label>
                    <input type="email" name="email" value="{{ old('email', $kontak['email'] ?? '') }}"
                           placeholder="Contoh: sdn2dermolo@gmail.com"
                           class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tautan Google Maps</label>
                <input type="url" name="maps_url" value="{{ old('maps_url', $kontak['maps_url'] ?? '') }}"
                       placeholder="Contoh: https://maps.google.com/?q=SD+N+2+Dermolo"
                       class="w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('maps_url')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-500 mt-1">Jika diisi, alamat akan bisa diklik dan menuju Google Maps.</p>
            </div>

            <div class="flex items-center justify-end gap-2">
                <button type="submit"
                        class="px-5 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan Kontak
                </button>
            </div>
        </form>
    </div>
@endsection
