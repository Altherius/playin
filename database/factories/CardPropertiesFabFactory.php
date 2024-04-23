<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardPropertiesFab>
 */
class CardPropertiesFabFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Lace with Inertia',
            'resource_cost' => 1,
            'pitch' => 0,
            'type_line' => 'Ranger Action',
            'rules_text' => 'Your next arrow attack this turn gains +3 Attack and
            "When this hits a hero, create an Inertia token under their control."
            Go again.',
            'attack' => null,
            'defense' => 2,
        ];
    }
}
