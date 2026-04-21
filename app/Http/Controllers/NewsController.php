<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('articles') || !Schema::hasTable('categories')) {
            return view('news.index', [
                'articles' => $this->emptyPaginator(9),
                'latest' => collect(),
                'categories' => collect(),
                'selectedCategory' => null,
                'selectedType' => null,
                'queryText' => (string) $request->string('q'),
            ]);
        }

        $filters = $request->only(['q', 'category', 'type']);
        $selectedType = $filters['type'] ?? null;
        if (! in_array($selectedType, ['berita', 'artikel'], true)) {
            $selectedType = null;
        }

        $articles = Article::with(['category', 'author'])
            ->published()
            ->filter($filters)
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $selectedCategory = null;
        if ($request->filled('category')) {
            $selectedCategory = Category::where('slug', $request->string('category'))->first();
        }

        $latest = Article::published()
            ->filter($request->only(['category', 'type']))
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = Category::withCount(['articles' => function ($q) use ($selectedType) {
            $q->published();
            if ($selectedType && Schema::hasColumn('articles', 'type')) {
                $q->where('type', $selectedType);
            }
        }])->orderBy('name')->get();

        $queryText = (string) ($filters['q'] ?? '');

        return view('news.index', compact('articles', 'latest', 'categories', 'selectedCategory', 'selectedType', 'queryText'));
    }

    public function show(Article $article, Request $request)
    {
        if ($article->status !== 'published') {
            abort(404);
        }

        $article->load(['category', 'author']);

        $sessionKey = 'article_viewed_' . $article->id;
        if (!$request->session()->has($sessionKey)) {
            ArticleView::create([
                'article_id' => $article->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
            $article->increment('view_count');
            $request->session()->put($sessionKey, true);
        }

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when(Schema::hasColumn('articles', 'type'), function ($q) use ($article) {
                if (! empty($article->type)) {
                    $q->where('type', $article->type);
                }
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('news.show', compact('article', 'related'));
    }

    public function category(Category $category, Request $request)
    {
        return redirect()->route('news.index', array_merge($request->query(), ['category' => $category->slug]));
    }

    public function search(Request $request)
    {
        return redirect()->route('news.index', $request->query());
    }

    protected function emptyPaginator(int $perPage): LengthAwarePaginator
    {
        return new LengthAwarePaginator([], 0, $perPage, 1, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }

    protected function applyArticleTypeFilter($query, ?string $type = null)
    {
        if (Schema::hasColumn('articles', 'type')) {
            if ($type) {
                $query->where('type', $type);
            }
        }

        return $query;
    }
}
