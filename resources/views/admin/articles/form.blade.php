@extends('admin.layout')

@section('title', $article->exists ? 'Edit Artikel' : 'Tambah Artikel')
@section('heading', $article->exists ? 'Edit Artikel' : 'Tambah Artikel')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        trix-editor {
            min-height: 320px;
            background: white;
            border-radius: 1rem;
        }
        trix-editor:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(15,23,42,0.2);
        }
    </style>
@endpush

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="grid lg:grid-cols-3 gap-6">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="lg:col-span-2 space-y-5">
            <div class="glass rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Konten Artikel</h2>
                        <p class="text-sm text-slate-500">Isi artikel yang akan tampil di halaman publik.</p>
                    </div>
                    <button type="button" id="ai-open"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-xs hover:opacity-90 transition">
                        Generate with AI
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Judul</label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $article->title) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                            placeholder="Judul artikel">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Slug (URL)</label>
                        <input type="text" name="slug" id="slug"
                            value="{{ old('slug', $article->slug) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                            placeholder="contoh: berita-sekolah">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle"
                            value="{{ old('subtitle', $article->subtitle) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                            placeholder="Ringkasan singkat di bawah judul">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Ringkasan</label>
                        <textarea name="summary" id="summary" rows="3"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                            placeholder="Gunakan untuk meta description dan preview.">{{ old('summary', $article->summary) }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Konten</label>
                        <input id="content" type="hidden" name="content" value="{{ old('content', $article->content) }}">
                        <trix-editor input="content"></trix-editor>
                    </div>
                </div>
            </div>

            <div class="glass rounded-3xl p-6">
                <h2 class="text-lg font-semibold text-slate-900">SEO & Metadata</h2>
                <div class="space-y-4 mt-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Meta Title</label>
                        <input type="text" name="meta_title"
                            value="{{ old('meta_title', $article->meta_title) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                            placeholder="Judul untuk SEO (opsional)">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Meta Description</label>
                        <textarea name="meta_description" rows="3"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                            placeholder="Deskripsi untuk mesin pencari">{{ old('meta_description', $article->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="glass rounded-3xl p-6">
                <h2 class="text-lg font-semibold text-slate-900">Pengaturan</h2>
                <div class="space-y-4 mt-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Kategori</label>
                        <select name="category_id" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
                            <option value="">Tanpa kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Status</label>
                        <select name="status" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
                            <option value="draft" @selected(old('status', $article->status) === 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $article->status) === 'published')>Published</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Tanggal Publish (opsional)</label>
                        <input type="datetime-local" name="published_at"
                            value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
                    </div>
                </div>
            </div>

            <div class="glass rounded-3xl p-6">
                <h2 class="text-lg font-semibold text-slate-900">Featured Image</h2>
                <div class="space-y-4 mt-4">
                    @if ($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured"
                            class="w-full h-40 object-cover rounded-2xl border border-slate-200">
                    @endif
                    <input type="file" name="featured_image"
                        class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:bg-slate-900 file:text-white hover:file:opacity-90">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.articles.index') }}"
                    class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
                <button type="submit"
                    class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan Artikel
                </button>
            </div>
        </div>
    </form>

    {{-- Modal AI --}}
    <div id="ai-modal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-3xl w-full max-w-lg p-6">
            <h3 class="text-lg font-semibold text-slate-900">Generate Draft Artikel</h3>
            <p class="text-sm text-slate-500 mt-1">Masukkan topik atau kata kunci untuk memulai draft.</p>
            <textarea id="ai-topic" rows="3"
                class="mt-4 w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300"
                placeholder="Contoh: Kegiatan lomba sains kelas 5 minggu ini"></textarea>
            <div class="mt-5 flex items-center justify-end gap-3">
                <button type="button" id="ai-close"
                    class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="button" id="ai-generate"
                    class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Generate
                </button>
            </div>
            <p id="ai-error" class="text-sm text-red-600 mt-4 hidden"></p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        const slugInput = document.getElementById('slug');
        const titleInput = document.getElementById('title');
        const aiModal = document.getElementById('ai-modal');
        const aiOpen = document.getElementById('ai-open');
        const aiClose = document.getElementById('ai-close');
        const aiGenerate = document.getElementById('ai-generate');
        const aiTopic = document.getElementById('ai-topic');
        const aiError = document.getElementById('ai-error');
        const contentInput = document.getElementById('content');

        function slugify(text) {
            return text.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }

        titleInput?.addEventListener('input', () => {
            if (!slugInput.value) {
                slugInput.value = slugify(titleInput.value);
            }
        });

        aiOpen?.addEventListener('click', () => {
            aiModal.classList.remove('hidden');
            aiModal.classList.add('flex');
            aiError.classList.add('hidden');
        });
        aiClose?.addEventListener('click', () => {
            aiModal.classList.add('hidden');
            aiModal.classList.remove('flex');
        });

        aiGenerate?.addEventListener('click', async () => {
            aiError.classList.add('hidden');
            const topic = aiTopic.value.trim();
            if (!topic) {
                aiError.textContent = 'Topik tidak boleh kosong.';
                aiError.classList.remove('hidden');
                return;
            }

            aiGenerate.disabled = true;
            aiGenerate.textContent = 'Memproses...';

            try {
                const res = await fetch("{{ route('admin.articles.ai-generate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({ topic })
                });

                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || 'Gagal menghasilkan draft.');
                }

                if (data.title) document.getElementById('title').value = data.title;
                if (data.subtitle) document.getElementById('subtitle').value = data.subtitle;
                if (data.summary) document.getElementById('summary').value = data.summary;
                if (data.content_html) {
                    contentInput.value = data.content_html;
                    const trix = document.querySelector('trix-editor');
                    if (trix) {
                        trix.editor.loadHTML(data.content_html);
                    }
                }

                aiModal.classList.add('hidden');
                aiModal.classList.remove('flex');
            } catch (err) {
                aiError.textContent = err.message;
                aiError.classList.remove('hidden');
            } finally {
                aiGenerate.disabled = false;
                aiGenerate.textContent = 'Generate';
            }
        });
    </script>
@endpush
