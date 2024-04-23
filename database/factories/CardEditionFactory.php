<?php

namespace Database\Factories;

use App\Enums\CardGame;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardEdition>
 */
class CardEditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'card_game' => fake()->randomElement(CardGame::cases())->value,
            'released_at' => fake()->dateTimeThisDecade(),
        ];
    }
}
