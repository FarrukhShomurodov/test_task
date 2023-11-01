<?php

namespace App\Services\Categories;

use App\Models\ParentCategory;
use Illuminate\Support\Str;

class ParentCategoryService
{
    public function index()
    {
        return ParentCategory::query()->get();
    }

    public function store($validated)
    {
        $validated['slug'] =  Str::slug($validated['name']);
        return ParentCategory::query()->create($validated);
    }

    public function update(ParentCategory $parentCategory, $validated)
    {
        return $parentCategory->update($validated);
    }

    public function destroy(ParentCategory $parentCategory)
    {
        $categories = $parentCategory->category()->get();
        foreach ($categories as $category){
            $category->subCategory()->delete();
        }
        $parentCategory->category()->delete();
        return $parentCategory->delete();
    }
}
