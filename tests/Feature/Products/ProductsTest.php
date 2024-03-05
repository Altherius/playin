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

    public function test_products_can_be_created(): void
    {
        $response = $this->post('/api/products', [
            'name' => 'Test product',
            'price' => 29.9,
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
