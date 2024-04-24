<?php

namespace Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_is_available(): void
    {
        $response = $this->get('/api/products');
        $response->assertOk();
    }

    public function test_products_page_is_available(): void
    {
        $product = Product::factory()->create();

        $response = $this->get("/api/products/$product->id");
        $response->assertOk();
    }

    public function test_boardgames_page_contains_properties(): void
    {
        $product = Product::factory()->boardgame()->create();

        $response = $this->get("/api/products/$product->id");

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'boardgame_properties'
        ]]);
    }

    public function test_magic_card_page_contains_properties(): void
    {
        $product = Product::factory()->magic()->create();

        $response = $this->get("/api/products/$product->id");

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'card_properties',
            'card_release',
            'card_print_state'
        ]]);
    }

    public function test_yugioh_card_page_contains_properties(): void
    {
        $product = Product::factory()->yugioh()->create();

        $response = $this->get("/api/products/$product->id");

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'card_properties',
            'card_release',
            'card_print_state'
        ]]);
    }

    public function test_fab_card_page_contains_properties(): void
    {
        $product = Product::factory()->fab()->create();

        $response = $this->get("/api/products/$product->id");

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'card_properties',
            'card_release',
            'card_print_state'
        ]]);
    }

    public function test_lorcana_card_page_contains_properties(): void
    {
        $product = Product::factory()->lorcana()->create();

        $response = $this->get("/api/products/$product->id");

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            'card_properties',
            'card_release',
            'card_print_state'
        ]]);
    }

    public function test_products_can_be_created(): void
    {
        $response = $this->post('/api/products', [
            'name' => 'Test product',
            'price' => 29.9,
            'card_game' => null,
        ]);

        $response->assertCreated();
    }

    public function test_products_can_be_updated(): void
    {
        $product = Product::factory()->create();

        $response = $this->put("/api/products/$product->id", [
            'name' => 'Test product',
            'price' => 29.9,
        ]);

        $response->assertOk();
    }
}
