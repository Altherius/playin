<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'validated' => false,
            'retailer_id' => User::factory(),
            'store_id' => Store::factory(),
            'address_id' => Address::factory(),
        ];
    }

    /**
     * Indicate that the order should be validated.
     */
    public function validated(): static
    {
        return $this->state(fn (array $attributes) => [
            'validated' => true,
        ]);
    }
}
