<?php

namespace Database\Factories\User\Favorite;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User\Favorite\Favorite;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User\User\User::factory(),
            'meal_id' => \App\Models\Catalog\Meal\Meal::factory(),
        ];
    }
}
