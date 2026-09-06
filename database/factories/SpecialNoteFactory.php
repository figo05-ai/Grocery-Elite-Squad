<?php

namespace Database\Factories;

use App\Models\SpecialNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpecialNote>
 */
class SpecialNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
