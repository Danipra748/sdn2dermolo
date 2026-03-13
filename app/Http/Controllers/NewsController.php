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
    public function index()
    {
        if (!Schema::hasTable('articles') || !Schema::hasTable('categories')) {
            return view('news.index', [
                'articles' => $this->emptyPaginator(9),
                'latest' => collect(),
                'categories' => collect(),
            ]);
        }

        $articles = Article::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->paginate(9);

        $latest = Article::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = Category::withCount(['articles' => function ($q) {
            $q->published();
        }])->orderBy('name')->get();

        return view('news.index', compact('articles', 'latest', 'categories'));
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
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('news.show', compact('article', 'related'));
    }

    public function category(Category $category)
    {
        if (!Schema::hasTable('articles')) {
            return view('news.category', [
                'category' => $category,
                'articles' => $this->emptyPaginator(9),
            ]);
        }

        $articles = $category->articles()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('news.category', compact('category', 'articles'));
    }

    public function search(Request $request)
    {
        $query = $request->string('q');

        if (!Schema::hasTable('articles')) {
            return view('news.search', [
                'articles' => $this->emptyPaginator(9),
                'query' => $query,
            ]);
        }

        $articles = Article::with(['category', 'author'])
            ->published()
            ->when($query, function ($builder) use ($query) {
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
}
