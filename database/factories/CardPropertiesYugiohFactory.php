<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardPropertiesMagic>
 */
class CardPropertiesYugiohFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Cyber Dragon',
            'level' => 5,
            'type_line' => 'Machine / Effect',
            'rules_text' => 'If only your opponent controls a monster, you can Special Summon this card (from your hand).',
            'atk' => 2100,
            'def' => 1600,
        ];
    }
}
