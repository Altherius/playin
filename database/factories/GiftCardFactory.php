<?php

namespace Database\Factories;

use App\Enums\GiftCardStatus;
use App\Enums\ProductType;
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
            'status' => fake()->randomElement(GiftCardStatus::cases()),
        ];
    }

    public function inactive(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => GiftCardStatus::INACTIVE,
        ]);
    }

    public function active(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => GiftCardStatus::ACTIVE,
        ]);
    }

    public function used(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'status' => GiftCardStatus::USED,
        ]);
    }
}
