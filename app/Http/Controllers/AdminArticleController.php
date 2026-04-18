<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\Modules\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

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
        $article = new Article(['status' => 'draft', 'type' => 'artikel']);
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
        $data = $this->validateArticle($request);
        $this->articleService->store($data, $request);

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
        $data = $this->validateArticle($request, $article->id);
        $this->articleService->update($article, $data, $request);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->articleService->delete($article);
        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }

    public function generateAi(Request $request)
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:160'],
        ]);

        $data = $this->articleService->generateAiDraft($request->input('topic'));

        if (!$data) {
            return response()->json([
                'message' => 'Gagal menghasilkan draft. Pastikan API KEY sudah benar.',
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
            'type' => ['required', 'in:berita,artikel'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
