<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardPropertiesMagic>
 */
class CardPropertiesLorcanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Mickey Mouse - Wayward Sorcerer',
            'cost' => 4,
            'can_be_ink' => true,
            'type_line' => 'Dreamborn / Sorcerer',
            'rules_text' => 'ANIMATE BROOM You pay 1 less to play Broom characters.
            CEASELESS WORKER Whenever one of your Broom characters is banished in a challenge, you may return that card to your hand.',
            'power' => 3,
            'toughness' => 4,
            'lore' => 2,
        ];
    }
}
