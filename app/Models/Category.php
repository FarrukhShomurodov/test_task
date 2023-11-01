<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "parent_category_id",
        "slug"
    ];

    public function subCategory(): HasMany
    {
        return $this->hasMany(SubCategory::class, "category_id", "id");
    }
}
