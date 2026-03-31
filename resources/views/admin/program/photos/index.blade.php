@extends('admin.layout')

@section('title', 'Dokumentasi Program')
@section('heading', 'Dokumentasi Program')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">{{ $programSekolah->title }}</h2>
            <p class="text-sm text-slate-500">Kelola foto dokumentasi dan deskripsinya.</p>
        </div>
        <a href="{{ route('admin.program-sekolah.photos.create', $programSekolah) }}"
           class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
            + Tambah Foto
        </a>
    </div>

    <div class="glass rounded-3xl p-6">
        <div class="grid md:grid-cols-3 gap-4">
            @forelse ($photos as $photo)
                <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white">
                    <img src="{{ asset('storage/' . $photo->photo) }}" alt="Dokumentasi {{ $programSekolah->title }}"
                         class="h-40 w-full object-cover">
                    <div class="p-4">
                        <p class="text-sm font-semibold text-slate-900">{{ $photo->caption ?: 'Dokumentasi program.' }}</p>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('admin.program-sekolah.photos.edit', [$programSekolah, $photo]) }}"
                               class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">Edit</a>
                            <form action="{{ route('admin.program-sekolah.photos.destroy', [$programSekolah, $photo]) }}"
                                  method="POST" data-confirm="Hapus foto ini?">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded-xl bg-white border border-slate-200 text-xs">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-slate-500">Belum ada dokumentasi.</div>
            @endforelse
        </div>
    </div>
@endsection

