<?php

namespace App\Http\Resources;

use App\Models\ParentCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent_category_id = $this->parent_category_id;
        $parent_category = ParentCategory::query()->find($parent_category_id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'slug' => $this->slug,
            'parent_category_id' => ParentCategoryResource::make($parent_category),
            'weight' => $this->weight
        ];
    }
}
