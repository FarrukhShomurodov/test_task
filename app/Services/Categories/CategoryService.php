<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function index()
    {
        return Category::query()->get();
    }

    public function store($validated)
    {
        $validated['slug'] =  Str::slug($validated['name']);
        return Category::query()->create($validated);
    }

    public function update(Category $category, $validated)
    {
        return $category->update($validated);
    }

    public function destroy(Category $category)
    {
        $category->subCategory()->delete();
        return $category->delete();
    }
}
