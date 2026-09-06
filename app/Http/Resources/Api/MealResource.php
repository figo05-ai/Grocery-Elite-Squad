<?php

namespace App\Http\Resources\Api;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    public function __construct(
        Meal $resource,
        private readonly array $extras = [],
        private readonly array|null|false $categoryShape = false,
    ) {
        parent::__construct($resource);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Meal $meal */
        $meal = $this->resource;

        if ($this->categoryShape === false) {
            // Default: direct access — crashes if category is null (same as original formatMeal behaviour).
            $category = ['id' => $meal->category->id, 'name' => $meal->category->name];
        } else {
            $category = $this->categoryShape;
        }

        return array_merge([
            'id'          => $meal->id,
            'title'       => $meal->title,
            'slug'        => $meal->slug,
            'description' => $meal->description,
            'image_url'   => $meal->image_url,
            'offer_title' => $meal->offer_title,
            ...$meal->getApiPriceAttributes(),
            'has_offer' => $meal->hasOffer(),
            'category'  => $category,
            'features'  => $meal->features,
        ], $this->extras);
    }

    /**
     * Derive the recommendation display string from meal attributes.
     * Extracted from the controller so presentation logic stays in the formatting layer.
     */
    public static function recommendationReason(Meal $meal): string
    {
        if ($meal->is_featured && $meal->discount_price) {
            return 'Featured with special offer';
        }
        if ($meal->is_featured) {
            return 'Featured meal';
        }
        if ($meal->discount_price) {
            return 'Special offer';
        }
        return 'Popular choice';
    }
}
