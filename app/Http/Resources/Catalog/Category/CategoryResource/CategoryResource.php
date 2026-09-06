<?php

namespace App\Http\Resources\Catalog\Category\CategoryResource;

use App\Models\Catalog\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Category
 */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'banner_url' => $this->banner_url,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'is_featured' => $this->is_featured,
            'created_at' => $this->created_at,
        ];
    }
}
