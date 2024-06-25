<?php

namespace Database\Factories;

use App\Enums\GiftCardStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCard>
 */
class GiftCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barcode' => fake()->ean13(),
            'value' => fake()->randomElement([20., 50., 100.]),
            'status' => fake()->randomElement(GiftCardStatus::cases())
        ];
    }
}
