<?php

namespace Tests\Feature\Stocks;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_items_can_be_created(): void
    {
        $product = Product::factory()->create();
        $stock = Stock::factory()->create();

        $response = $this->post('/api/stock-items', [
            'stock_id' => $stock->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'unit_price' => 19.9,
        ]);

        $response->assertOk();
    }

    public function test_stock_items_can_be_updated(): void
    {
        $item = StockItem::factory()->create();

        $response = $this->put("/api/stock-items/$item->id", [
            'stock_id' => $item->stock_id,
            'product_id' => $item->product_id,
            'quantity' => 3,
            'unit_price' => 14.9,
        ]);

        $response->assertOk();
    }
}
