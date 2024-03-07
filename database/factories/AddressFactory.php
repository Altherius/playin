<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $addressNames = ['Home', 'Work', 'Friend'];

        return [
            'address_name' => $addressNames[array_rand($addressNames)],
            'recipient_name' => fake()->name,
            'street' => fake()->streetAddress,
            'postal_code' => fake()->postcode,
            'locality' => fake()->city,
            'country' => fake()->country,
        ];
    }
}
