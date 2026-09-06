<?php

namespace Database\Factories\Catalog\Category;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Catalog\Category\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'is_active' => true,
        ];
    }
}
