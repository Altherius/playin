<?php

namespace Database\Factories;

use App\Enums\CardGrading;
use App\Enums\CardLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardPrintState>
 */
class CardPrintStateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grading' => fake()->randomElement(CardGrading::cases())->value,
            'language' => fake()->randomElement(CardLanguage::cases())->value
        ];
    }
}
