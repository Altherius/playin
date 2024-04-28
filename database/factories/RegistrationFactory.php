<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function withStoreAndUser(int $event_id, int $user_id): Factory
    {
        return $this->state(fn (array $attributes) => [
            'event_id' => $event_id,
            'user_id' => $user_id,
        ]);
    }
}
