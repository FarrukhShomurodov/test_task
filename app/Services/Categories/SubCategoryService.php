<?php

namespace App\Services\Categories;

use App\Models\SubCategory;
use Illuminate\Support\Str;

class SubCategoryService
{
    public function index()
    {
        return SubCategory::query()->get();
    }

    public function store($validated)
    {
        $validated['slug'] =  Str::slug($validated['name']);
        return SubCategory::query()->create($validated);
    }

    public function update(SubCategory $subCategory, $validated)
    {
        return $subCategory->update($validated);
    }

    public function destroy(SubCategory $subCategory)
    {
        return $subCategory->delete();
    }
}
