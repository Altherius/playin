<?php

namespace Database\Factories;

use App\Enums\CardGame;
use App\Enums\ProductType;
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
            'card_game' => fake()->randomElement(CardGame::cases())->value,
            'product_type' => ProductType::OTHER,
        ];
    }

    public function boardgame(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'slug' => null,
            'card_game' => null,
            'product_type' => ProductType::BOARDGAME->value,
            'boardgame_properties_id' => 1,
        ]);
    }

    public function magic(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'slug' => null,
            'card_game' => CardGame::MAGIC,
            'product_type' => ProductType::CARD->value,
            'card_properties_magic_id' => 1,
            'card_release_id' => 1,
            'card_print_state_id' => 1,
        ]);
    }

    public function yugioh(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'slug' => null,
            'card_game' => CardGame::YUGIOH,
            'product_type' => ProductType::CARD->value,
            'card_properties_yugioh_id' => 1,
            'card_release_id' => 1,
            'card_print_state_id' => 1,
        ]);
    }

    public function fab(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'slug' => null,
            'card_game' => CardGame::FAB,
            'product_type' => ProductType::CARD->value,
            'card_properties_fab_id' => 1,
            'card_release_id' => 1,
            'card_print_state_id' => 1,
        ]);
    }

    public function lorcana(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'slug' => null,
            'card_game' => CardGame::LORCANA,
            'product_type' => ProductType::CARD->value,
            'card_properties_lorcana_id' => 1,
            'card_release_id' => 1,
            'card_print_state_id' => 1,
        ]);
    }
}
