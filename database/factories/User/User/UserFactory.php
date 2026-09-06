<?php

namespace Database\Factories\User\User;

use App\Models\User\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '+2010'.$this->faker->numerify('########'),
            'email_verified' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('Password123'),
            'remember_token' => Str::random(10),
            'agree_terms' => true,
            'is_active' => true,
        ];
    }
}
