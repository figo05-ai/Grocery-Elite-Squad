<?php

namespace Database\Factories\Cart\Cart;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cart\Cart\Cart;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User\User\User::factory(),
        ];
    }
}
