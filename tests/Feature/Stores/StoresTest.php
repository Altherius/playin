<?php

namespace Tests\Feature\Stores;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoresTest extends TestCase
{
    use RefreshDatabase;

    public function test_stores_index_is_available(): void
    {
        $response = $this->get('/api/stores');
        $response->assertOk();
    }

    public function test_stores_page_is_available(): void
    {
        $store = Store::factory()->create();

        $response = $this->get("/api/stores/$store->id");
        $response->assertOk();
    }

    public function test_stores_can_be_created(): void
    {
        $response = $this->post('/api/stores', [
            'name' => 'Playin Test',
        ]);

        $response->assertCreated();
    }

    public function test_stores_can_be_updated(): void
    {
        $store = Store::factory()->create();

        $response = $this->put("/api/stores/$store->id", [
            'name' => 'Playin Test',
        ]);

        $response->assertOk();
    }
}
