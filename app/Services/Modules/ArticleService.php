<?php

namespace App\Services\Modules;

use App\Models\Article;
use App\Services\Core\FileService;
use App\Traits\CacheableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ArticleService
{
    use CacheableService;

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store a new article.
     */
    public function store(array $data, Request $request): Article
    {
        $this->clearModuleCache();
        $data['author_id'] = $request->user()->id;
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->fileService->upload($request, 'featured_image', 'articles');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return Article::create($data);
    }

    /**
     * Update an existing article.
     */
    public function update(Article $article, array $data, Request $request): Article
    {
        $this->clearModuleCache();
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], $article->id);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->fileService->replace($article->featured_image, $request, 'featured_image', 'articles');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        $article->update($data);

        return $article;
    }

    /**
     * Delete an article and its featured image.
     */
    public function delete(Article $article): bool
    {
        $this->clearModuleCache();
        $this->fileService->delete($article->featured_image);

        return $article->delete();
    }

    /**
     * Generate unique slug.
     */
    public function uniqueSlug(string $value, ?int $articleId = null): string
    {
        $base = Str::slug($value) ?: 'artikel';
        $slug = $base;
        $counter = 1;

        while (Article::where('slug', $slug)
            ->when($articleId, fn ($q) => $q->where('id', '!=', $articleId))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate article draft using AI.
     */
    public function generateAiDraft(string $topic): ?array
    {
        $apiKey = config('services.openai.key');
        $model = config('services.openai.model', 'gpt-4o-mini');

        if (empty($apiKey)) {
            return null;
        }

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
                        'content' => "Topik atau kata kunci: {$topic}",
                    ],
                ],
            ]);

        if (! $response->successful()) {
            return null;
        }

        $payload = $response->json();
        $text = data_get($payload, 'choices.0.message.content', '');

        // Handle markdown code blocks if AI returns them
        $text = preg_replace('/^```json\s*|```$/m', '', $text);

        return json_decode($text, true);
    }
}
