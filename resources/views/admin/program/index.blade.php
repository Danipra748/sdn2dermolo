@extends('admin.layout')

@section('title', 'Program Sekolah')
@section('heading', 'Program Sekolah')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Dokumentasi Program</h2>
                <p class="text-sm text-slate-500">Kelola foto dan deskripsi dokumentasi untuk setiap program.</p>
            </div>
        </div>

        <div class="mt-6 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($program as $item)
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-5 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->title }}"
                                 class="h-14 w-14 rounded-2xl object-cover border border-slate-200">
                        @else
                            <div class="h-14 w-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-xs">
                                No Img
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-slate-500">{{ $item->slug }}</p>
                            <h3 class="text-base font-semibold text-slate-900">{{ $item->title }}</h3>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600">Kelola dokumentasi foto program untuk ditampilkan di halaman publik.</p>
                    <form action="{{ route('admin.program-sekolah.card-background.update', $item) }}" method="POST"
                          enctype="multipart/form-data" class="space-y-2">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-medium text-slate-700">Background Kartu Program</label>
                        <input type="file" name="card_bg_image" accept=".jpg,.jpeg,.png,.webp"
                               class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs text-slate-700">
                        @if (!empty($item->card_bg_image))
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $item->card_bg_image) }}" alt="Background {{ $item->title }}"
                                     class="h-14 w-24 rounded-xl object-cover border border-slate-200">
                                <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                                    <input type="checkbox" name="remove_card_bg_image" value="1"
                                           class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                                    Hapus background
                                </label>
                            </div>
                        @endif
                        <button type="submit" class="px-3 py-2 rounded-xl bg-slate-900 text-white text-xs">
                            Simpan Background
                        </button>
                    </form>
                    <a href="{{ route('admin.program-sekolah.photos.index', $item) }}"
                       class="mt-auto inline-flex items-center justify-center px-4 py-2 rounded-2xl bg-slate-900 text-white text-xs">
                        Dokumentasi Program
                    </a>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white/70 p-6 text-center text-slate-500">
                    Data program belum tersedia.
                </div>
            @endforelse
        </div>
    </div>
@endsection
