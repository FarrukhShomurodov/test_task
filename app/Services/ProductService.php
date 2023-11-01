<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductService
{
    public function index()
    {
        return Product::query()->get();
    }

    public function store($validated)
    {
        $validated['slug'] =  Str::slug($validated['name']);
        return Product::query()->create($validated);
    }

    public function update(Product $product, $validated)
    {
        return $product->update($validated);
    }

    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
