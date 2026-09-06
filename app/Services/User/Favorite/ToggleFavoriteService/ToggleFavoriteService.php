<?php

namespace App\Services\User\Favorite\ToggleFavoriteService;

use App\Models\User\User\User;

class ToggleFavoriteService
{
    public function execute(User $user, string $mealId): array
    {
        $favorite = $user->favorites()->where('meal_id', $mealId)->first();
        if ($favorite) {
            $favorite->delete();

            return ['message' => 'Meal removed from favorites', 'is_favorite' => false];
        } else {
            $user->favorites()->create(['meal_id' => $mealId]);

            return ['message' => 'Meal added to favorites', 'is_favorite' => true];
        }
    }
}
