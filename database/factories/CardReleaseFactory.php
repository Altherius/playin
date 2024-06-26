<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardRelease>
 */
class CardReleaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'collection_number' => fake()->numberBetween(1, 300),
            'artist' => fake()->name(),
            'card_edition_id' => fake()->numberBetween(1, 10),
        ];
    }
}
