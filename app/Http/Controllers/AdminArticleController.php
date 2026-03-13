<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('articles')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel artikel belum tersedia. Jalankan migrasi terlebih dahulu.');
        }

        $query = Article::with(['category', 'author'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('q')) {
            $search = $request->string('q');
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%')
                    ->orWhere('summary', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->paginate(10)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        if (!Schema::hasTable('articles')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel artikel belum tersedia. Jalankan migrasi terlebih dahulu.');
        }

        $article = new Article(['status' => 'draft']);
        $categories = Schema::hasTable('categories') ? Category::orderBy('name')->get() : collect();

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => $categories,
            'action' => route('admin.articles.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        if (!Schema::hasTable('articles')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel artikel belum tersedia. Jalankan migrasi terlebih dahulu.');
        }

        $data = $this->validateArticle($request);
        $data['author_id'] = $request->user()->id;

        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['title']);
        } else {
            $data['slug'] = $this->uniqueSlug($data['slug']);
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        $categories = Schema::hasTable('categories') ? Category::orderBy('name')->get() : collect();

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => $categories,
            'action' => route('admin.articles.update', $article),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Article $article)
    {
        if (!Schema::hasTable('articles')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel artikel belum tersedia. Jalankan migrasi terlebih dahulu.');
        }

        $data = $this->validateArticle($request, $article->id);

        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['title'], $article->id);
        } else {
            $data['slug'] = $this->uniqueSlug($data['slug'], $article->id);
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if (!Schema::hasTable('articles')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel artikel belum tersedia. Jalankan migrasi terlebih dahulu.');
        }

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }

    public function generateAi(Request $request)
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:160'],
        ]);

        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4.1-mini');

        if (empty($apiKey)) {
            return response()->json([
                'message' => 'OPENAI_API_KEY belum diatur. Tambahkan ke .env untuk menggunakan AI.',
            ], 422);
        }

        $prompt = trim($request->input('topic'));

        $response = Http::withToken($apiKey)
            ->timeout(40)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'temperature' => 0.6,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that drafts Indonesian news articles for a school website. Return a JSON object with: title, subtitle, summary, content_html (HTML with H2/H3 headings and paragraphs).',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Topik atau kata kunci: {$prompt}",
                    ],
                ],
            ]);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Gagal menghasilkan draft. Silakan coba lagi.',
            ], 500);
        }

        $payload = $response->json();
        $text = data_get($payload, 'choices.0.message.content', '');

        $data = json_decode($text, true);
        if (!is_array($data)) {
            return response()->json([
                'message' => 'Format respons AI tidak valid. Silakan coba lagi.',
            ], 422);
        }

        return response()->json([
            'title' => $data['title'] ?? '',
            'subtitle' => $data['subtitle'] ?? '',
            'summary' => $data['summary'] ?? '',
            'content_html' => $data['content_html'] ?? '',
        ]);
    }

    protected function validateArticle(Request $request, ?int $articleId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'status' => ['required', 'in:draft,published'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    protected function uniqueSlug(string $value, ?int $articleId = null): string
    {
        $base = Str::slug($value) ?: 'artikel';
        $slug = $base;
        $counter = 1;

        while (Article::where('slug', $slug)
            ->when($articleId, fn ($q) => $q->where('id', '!=', $articleId))
            ->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

}
