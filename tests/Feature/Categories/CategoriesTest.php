<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_index_is_available(): void
    {
        $response = $this->get('/api/categories');
        $response->assertOk();
    }

    public function test_categories_page_is_available(): void
    {
        $category = Category::factory()->create();

        $response = $this->get("/api/categories/$category->id");
        $response->assertOk();
    }

    public function test_categories_can_be_created(): void
    {
        $response = $this->post('/api/categories', [
            'name' => 'Boosters Magic',
            'category_id' => null,
        ]);

        $response->assertCreated();
        $response->assertJson(fn (AssertableJson $json) => $json->where('data.name', 'Boosters Magic'));
    }

    public function test_categories_can_be_updated(): void
    {
        $category = Category::factory()->create();

        $response = $this->put("/api/categories/$category->id", [
            'name' => 'Boosters Magic',
            'category_id' => null,
        ]);

        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) => $json->where('data.name', 'Boosters Magic'));
    }

    public function test_categories_can_be_deleted(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete("/api/categories/$category->id");

        $response->assertNoContent();
    }
}
