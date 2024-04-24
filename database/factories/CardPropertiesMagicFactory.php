<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardPropertiesMagic>
 */
class CardPropertiesMagicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Lightning Bolt',
            'mana_cost' => '{R}',
            'mana_value' => 1,
            'type_line' => 'Instant',
            'rules_text' => 'Lightning Bolt deals 3 damage to any target.',
        ];
    }
}
