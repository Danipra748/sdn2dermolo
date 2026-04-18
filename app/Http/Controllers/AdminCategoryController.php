<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $category = new Category;

        return view('admin.categories.form', [
            'category' => $category,
            'action' => route('admin.categories.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', [
            'category' => $category,
            'action' => route('admin.categories.update', $category),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['name'], $category->id);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil dihapus.');
    }

    protected function validateCategory(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);
    }

    protected function uniqueSlug(string $value, ?int $categoryId = null): string
    {
        $base = Str::slug($value) ?: 'kategori';
        $slug = $base;
        $counter = 1;

        while (Category::where('slug', $slug)
            ->when($categoryId, fn ($q) => $q->where('id', '!=', $categoryId))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
