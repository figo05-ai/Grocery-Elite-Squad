<?php

namespace Database\Factories\User\Favorite;

use App\Models\Catalog\Meal\Meal;
use App\Models\User\Favorite\Favorite;
use App\Models\User\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'meal_id' => Meal::factory(),
        ];
    }
}
