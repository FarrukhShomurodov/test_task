<?php

namespace App\Http\Controllers\Api\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\SubCategoryResource;
use App\Services\Categories\SubCategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubCategoryController extends Controller
{
    protected SubCategoryService $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $subCategories = $this->subCategoryService->index();
        return SubCategoryResource::collection($subCategories);
    }

    /**
     * @param SubCategoryRequest $request
     * @return SubCategoryResource
     */
    public function store(SubCategoryRequest $request): SubCategoryResource
    {
        $subCategory = $this->subCategoryService->store($request->validated());
        return SubCategoryResource::make($subCategory);
    }
}
