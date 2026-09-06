<?php

namespace App\Http\Resources\Catalog\Meal\MealResource;

use App\Http\Resources\Catalog\Category\CategoryResource\CategoryResource;
use App\Http\Resources\Catalog\Subcategory\SubcategoryResource\SubcategoryResource;
use App\Models\Catalog\Meal\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Meal
 */
class MealResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user('sanctum');
        $isFavorited = false;

        // This could be optimized if favorite_meal_ids is passed in via additional data or loaded relation
        if ($user && $this->relationLoaded('favorites')) {
            $isFavorited = $this->favorites->where('user_id', $user->id)->isNotEmpty();
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'offer_title' => $this->offer_title,
            ...$this->getApiPriceAttributes(),
            'has_offer' => $this->hasOffer(),
            'rating' => (float) $this->rating,
            'rating_count' => (int) $this->rating_count,
            'size' => $this->size,
            'brand' => $this->brand,
            'stock_quantity' => (int) $this->stock_quantity,
            'in_stock' => $this->isInStock(),
            'is_featured' => $this->is_featured,
            'sold_count' => $this->sold_count,
            'category' => $this->whenLoaded('category', fn () => new CategoryResource($this->category)),
            'subcategory' => $this->whenLoaded('subcategory', fn () => new SubcategoryResource($this->subcategory)),
            'features' => $this->features,
            'is_favorited' => $isFavorited,
            'recommendation_reason' => $this->additional['recommendation_reason'] ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
