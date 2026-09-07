<?php

namespace App\Http\Resources\Api;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealDetailResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Meal $meal */
        $meal = $this->resource;

        return [
            'id'          => $meal->id,
            'title'       => $meal->title,
            'slug'        => $meal->slug,
            'description' => $meal->description,
            'image_url'   => $meal->image_url,
            'offer_title' => $meal->offer_title,

            // Pricing
            ...$meal->getApiPriceAttributes(),
            'has_offer' => $meal->hasOffer(),

            // Rating
            'rating'       => (float) $meal->rating,
            'rating_count' => (int) $meal->rating_count,

            // Product details
            'size'       => $meal->size,
            'brand'      => $meal->brand,
            'includes'   => $meal->includes,
            'how_to_use' => $meal->how_to_use,
            'features'   => $meal->features,

            // Expiry and availability
            'expiry_date'       => $meal->expiry_date,
            'days_until_expiry' => $meal->daysUntilExpiry(),
            'is_expired'        => $meal->isExpired(),

            // Stock
            'stock_quantity' => $meal->stock_quantity,
            'in_stock'       => $meal->isInStock(),
            'sold_count'     => $meal->sold_count,

            // Status
            'is_featured'    => $meal->is_featured,
            'is_available'   => $meal->is_available,
            'available_date' => $meal->available_date,

            // Relationships
            'category' => [
                'id'   => $meal->category->id,
                'name' => $meal->category->name,
                'slug' => $meal->category->slug,
            ],
            'reviews' => $meal->reviews->map(function ($review) {
                return [
                    'id'   => $review->id,
                    'user' => $review->relationLoaded('user') && $review->user ? [
                        'id'   => $review->user->id,
                        'name' => $review->user->full_name ?? $review->user->username ?? 'User',
                    ] : null,
                    'rating'     => (int) $review->rating,
                    'comment'    => $review->comment,
                    'images'     => $review->images ?? [],
                    'created_at' => $review->created_at?->toIso8601String(),
                ];
            })->values(),
            'subcategory' => $meal->subcategory ? [
                'id'   => $meal->subcategory->id,
                'name' => $meal->subcategory->name,
                'slug' => $meal->subcategory->slug,
            ] : null,

            'created_at' => $meal->created_at,
            'updated_at' => $meal->updated_at,
        ];
    }
}
