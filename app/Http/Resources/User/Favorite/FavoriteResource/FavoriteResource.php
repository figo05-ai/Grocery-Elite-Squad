<?php

namespace App\Http\Resources\User\Favorite\FavoriteResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User\Favorite\Favorite
 */
class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $meal = $this->meal;

        return [
            'id' => $meal->id,
            'title' => $meal->title,
            'slug' => $meal->slug,
            'image_url' => $meal->image_url,
            'price' => (float) $meal->price,
            'has_offer' => $meal->hasOffer(),
            'category' => $meal->category ? ['id' => $meal->category->id, 'name' => $meal->category->name] : null,
            'is_favorited' => true,
            'favorited_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
