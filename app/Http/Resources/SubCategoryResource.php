<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category_id = $this->category_id;
        $category = Category::query()->find($category_id);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category" => CategoryResource::make($category)
        ];
    }
}
