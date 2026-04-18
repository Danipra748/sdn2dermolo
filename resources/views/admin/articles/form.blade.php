@extends('admin.layout')

@php
    $isEdit = isset($article) && $article->id;
    $title = $isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru';
    $icon = $isEdit 
        ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>'
        : '<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>';
@endphp

@section('title', $title)
@section('heading', $title)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px !important;
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 8px !important;
        }
    </style>
@endpush

@section('content')
    <form action="{{ $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Main Content Column --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card p-6">
                    <x-admin.form-group label="Judul Artikel" name="title" required>
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title ?? '') }}" class="w-full form-input" required>
                    </x-admin.form-group>
                </div>

                <div class="glass-card p-6">
                    <x-admin.form-group label="Konten Artikel" name="content" help="Gunakan sintaks Markdown untuk format teks.">
                        <textarea name="content" id="content" rows="15" class="w-full form-input">{{ old('content', $article->content ?? '') }}</textarea>
                    </x-admin.form-group>
                </div>

                <div class="glass-card p-6">
                    <x-admin.form-group label="Ringkasan (Opsional)" name="summary" help="Ringkasan singkat artikel. Jika kosong, akan dibuat otomatis dari konten.">
                        <textarea name="summary" id="summary" rows="3" class="w-full form-input">{{ old('summary', $article->summary ?? '') }}</textarea>
                    </x-admin.form-group>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Publikasi</h3>
                    <div class="space-y-4">
                        <x-admin.form-group label="Status" name="status">
                            <select name="status" id="status" class="w-full form-input">
                                <option value="published" @selected(old('status', $article->status ?? 'published') == 'published')>Published</option>
                                <option value="draft" @selected(old('status', $article->status ?? 'published') == 'draft')>Draft</option>
                            </select>
                        </x-admin.form-group>

                        <x-admin.form-group label="Tanggal Publikasi (Opsional)" name="published_at">
                            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', ($article->published_at ?? now())->format('Y-m-d\TH:i')) }}" class="w-full form-input">
                        </x-admin.form-group>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Pengaturan</h3>
                    <div class="space-y-4">
                        <x-admin.form-group label="Kategori" name="category_id">
                            <select name="category_id" id="category_id" class="w-full form-input select2">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </x-admin.form-group>

                        <x-admin.form-group label="Tipe Konten" name="type">
                            <select name="type" id="type" class="w-full form-input">
                                <option value="berita" @selected(old('type', $article->type ?? 'berita') == 'berita')>Berita</option>
                                <option value="artikel" @selected(old('type', $article->type ?? 'berita') == 'artikel')>Artikel</option>
                                <option value="pengumuman" @selected(old('type', $article->type ?? 'berita') == 'pengumuman')>Pengumuman</option>
                            </select>
                        </x-admin.form-group>
                    </div>
                </div>

                <div class="glass-card p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Gambar Unggulan</h3>
                    <div class="w-full aspect-video rounded-xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden">
                        <img id="image-preview" src="{{ $isEdit && $article->featured_image ? asset('storage/' . $article->featured_image) : '' }}" class="{{ $isEdit && $article->featured_image ? '' : 'hidden' }} w-full h-full object-cover">
                        <label for="featured_image" id="image-placeholder" class="{{ $isEdit && $article->featured_image ? 'hidden' : '' }} text-center text-slate-400 cursor-pointer">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            <span class="text-xs font-semibold">Klik untuk memilih gambar</span>
                        </label>
                    </div>
                    <input type="file" name="featured_image" id="featured_image" class="hidden" accept="image/*">
                </div>
            </div>
        </div>

        {{-- Sticky Footer on Mobile --}}
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 border-t border-slate-200 backdrop-blur-sm lg:hidden z-10">
            <div class="flex items-center gap-3">
                <x-admin.button href="{{ route('admin.articles.index') }}" variant="secondary" size="md" class="w-full">Batal</x-admin.button>
                <x-admin.button type="submit" variant="primary" size="md" class="w-full">{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan' }}</x-admin.button>
            </div>
        </div>
        
        {{-- Desktop Actions --}}
        <div class="hidden lg:flex items-center gap-3 mt-8">
            <x-admin.button href="{{ route('admin.articles.index') }}" variant="secondary">Batal</x-admin.button>
            <x-admin.button type="submit" variant="primary">{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan' }}</x-admin.button>
        </div>
    </form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    document.getElementById('featured_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('image-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
