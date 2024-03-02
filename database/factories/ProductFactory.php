<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst($name = fake()->words(fake()->numberBetween(2, 3), true)),
            'slug' => Str::slug($name),
            'price' => round(10 * fake()->randomFloat(2, 10, 100)) / 10,
        ];
    }
}
