<?php

namespace App\Http\Controllers\Api\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParentCategoryRequest;
use App\Http\Resources\ParentCategoryResource;
use App\Services\Categories\ParentCategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ParentCategoryController extends Controller
{
    protected ParentCategoryService $parentCategoryService;

    public function __construct(ParentCategoryService $parentCategoryService)
    {
        $this->parentCategoryService = $parentCategoryService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $parentCategories = $this->parentCategoryService->index();
        return ParentCategoryResource::collection($parentCategories);
    }

    /**
     * @param ParentCategoryRequest $request
     * @return ParentCategoryResource
     */
    public function store(ParentCategoryRequest $request): ParentCategoryResource
    {
        $parentCategory = $this->parentCategoryService->store($request->validated());
        return ParentCategoryResource::make($parentCategory);
    }
}
