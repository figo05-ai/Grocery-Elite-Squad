<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,

            'image_url' => $this->image_url,
            'offer_title' => $this->offer_title,

            // Pricing
            ...$this->getApiPriceAttributes(),

            'has_offer' => $this->hasOffer(),

            // Rating
            'rating' => (float) $this->rating,
            'rating_count' => (int) $this->rating_count,

            // Product Details
            'size' => $this->size,
            'brand' => $this->brand,
            'includes' => $this->includes,
            'how_to_use' => $this->how_to_use,

            // Stock
            'stock_quantity' => (int) $this->stock_quantity,
            'in_stock' => $this->isInStock(),

            // Featured
            'is_featured' => (bool) $this->is_featured,

            // Sales
            'sold_count' => (int) $this->sold_count,

            // Features
            'features' => $this->features,

            // Dates
            'available_date' => $this->available_date,
            'expiry_date' => $this->expiry_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Category
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                ];
            }),

            // Subcategory
            'subcategory' => $this->whenLoaded('subcategory', function () {
                return $this->subcategory ? [
                    'id' => $this->subcategory->id,
                    'name' => $this->subcategory->name,
                    'slug' => $this->subcategory->slug,
                ] : null;
            }),
        ];
    }
}
