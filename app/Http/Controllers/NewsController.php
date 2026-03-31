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

        $selectedType = $request->string('type')->toString();
        if (! in_array($selectedType, ['berita', 'artikel'], true)) {
            $selectedType = null;
        }

        $query = Article::with(['category', 'author'])
            ->published();
        $query = $this->applyArticleTypeFilter($query, $selectedType);

        $selectedCategory = null;
        if ($request->filled('category')) {
            $selectedCategory = Category::where('slug', $request->string('category'))->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $search = $request->string('q');
        if ($search->isNotEmpty()) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%')
                    ->orWhere('summary', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $articles = $query->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $latestQuery = Article::published();
        $latestQuery = $this->applyArticleTypeFilter($latestQuery, $selectedType);
        if ($selectedCategory) {
            $latestQuery->where('category_id', $selectedCategory->id);
        }

        $latest = $latestQuery->latest('published_at')
            ->take(3)
            ->get();

        $categories = Category::withCount(['articles' => function ($q) use ($selectedType) {
            $q->published();
            $this->applyArticleTypeFilter($q, $selectedType);
        }])->orderBy('name')->get();

        $queryText = (string) $search;

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
        if (!Schema::hasTable('articles')) {
            return view('news.category', [
                'category' => $category,
                'articles' => $this->emptyPaginator(9),
            ]);
        }

        $selectedType = $request->string('type')->toString();
        if (! in_array($selectedType, ['berita', 'artikel'], true)) {
            $selectedType = null;
        }

        $categoryQuery = $category->articles()
            ->published();
        $this->applyArticleTypeFilter($categoryQuery, $selectedType);

        $articles = $categoryQuery->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('news.category', compact('category', 'articles'));
    }

    public function search(Request $request)
    {
        $query = $request->string('q');
        $selectedType = $request->string('type')->toString();
        if (! in_array($selectedType, ['berita', 'artikel'], true)) {
            $selectedType = null;
        }

        if (!Schema::hasTable('articles')) {
            return view('news.search', [
                'articles' => $this->emptyPaginator(9),
                'query' => $query,
            ]);
        }

        $searchQuery = Article::with(['category', 'author'])
            ->published();
        $this->applyArticleTypeFilter($searchQuery, $selectedType);

        $articles = $searchQuery->when($query, function ($builder) use ($query) {
            $builder->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('subtitle', 'like', '%' . $query . '%')
                    ->orWhere('summary', 'like', '%' . $query . '%')
                    ->orWhere('content', 'like', '%' . $query . '%');
            });
        })
        ->latest('published_at')
        ->paginate(9)
        ->withQueryString();

        return view('news.search', [
            'articles' => $articles,
            'query' => $query,
        ]);
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
