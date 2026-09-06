<?php

namespace Database\Factories\Cart\Cart;

use App\Models\Cart\Cart\Cart;
use App\Models\User\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
