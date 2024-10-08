<?php

namespace Tests\Feature\Stocks;

use App\Models\Stock;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StocksTest extends TestCase
{
    use RefreshDatabase;

    public function test_stocks_index_is_available(): void
    {
        $response = $this->get('/api/stocks');
        $response->assertOk();
    }

    public function test_stocks_page_is_available(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->get("/api/stocks/$stock->id");
        $response->assertOk();
    }

    public function test_stocks_can_be_created(): void
    {
        $customer = User::factory()->create();
        $store = Store::factory()->create();

        $response = $this->post('/api/stocks', [
            'store_id' => $store->id,
            'retailer_id' => $customer->id,
        ]);

        $response->assertCreated();
    }

    public function test_stocks_can_be_updated(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->put("/api/stocks/$stock->id", [
            'validated' => false,
            'sent' => false,
            'received' => false,
        ],
            ['Accept' => 'application/json']
        );

        $response->assertOk();
    }

    public function test_stocks_cannot_be_received_if_not_sent(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->put("/api/stocks/$stock->id", [
            'validated' => false,
            'sent' => false,
            'received' => true,
        ],
            ['Accept' => 'application/json']
        );

        $response->assertUnprocessable();
    }

    public function test_stocks_cannot_be_sent_if_not_validated(): void
    {
        $stock = Stock::factory()->create();

        $response = $this->put("/api/stocks/$stock->id", [
            'validated' => false,
            'sent' => true,
            'received' => true,
        ],
            ['Accept' => 'application/json']
        );

        $response->assertUnprocessable();
    }
}
