<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardgameProperties>
 */
class BoardgamePropertiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minPlayersCount = fake()->numberBetween(1, 10);

        return [
            'min_player_count' => $minPlayersCount,
            'max_player_count' => $minPlayersCount + fake()->numberBetween(0, 3),
            'game_length_minutes' => fake()->numberBetween(15, 90),
            'min_player_age' => fake()->numberBetween(0, 18),
            'max_player_age' => null,
        ];
    }
}
