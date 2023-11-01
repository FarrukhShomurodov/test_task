<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $products = $this->productService->index();
        return ProductResource::collection($products);
    }

    /**
     * @param ProductRequest $request
     * @return ProductResource
     */
    public function store(ProductRequest $request): ProductResource
    {
        $product = $this->productService->store($request->validated());
        return ProductResource::make($product);
    }

    /**
     * @param ParentCategory $parentCategory
     * @return AnonymousResourceCollection
     */
    public function show_by_category(ParentCategory $parentCategory): AnonymousResourceCollection
    {
        return ProductResource::collection($parentCategory->product()->get());
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function show_by_slug(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()->where('slug', '=', $request['slug'])->get();
        return ProductResource::collection($products);
    }
}
