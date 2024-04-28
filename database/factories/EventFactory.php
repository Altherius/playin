<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeThisYear();

        return [
            'name' => fake()->words(3, true),
            'start_time' => $start_date,
            'end_time' => $start_date->add(new \DateInterval('PT1H')),
            'max_capacity' => fake()->numberBetween(8, 64),
            'price' => fake()->numberBetween(0, 20),
            'store_id' => fake()->numberBetween(1, 3),
        ];
    }

    public function full(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'max_capacity' => 0,
        ]);
    }
}
