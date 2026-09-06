<?php

namespace Database\Factories\User\Address;

use App\Models\User\Address\Address;
use App\Models\User\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'label' => 'Home',
            'full_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'latitude' => 30.0,
            'longitude' => 31.0,
            'street_address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'is_default' => false,
        ];
    }
}
