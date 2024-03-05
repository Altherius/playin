<?php

namespace Stocks;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_items_can_be_created(): void
    {
        $retailer = User::factory()->create();
        $store = Store::factory()->create();
        $product = Product::factory()->create();

        $stock = new Stock();
        $stock->retailer_id = $retailer->id;
        $stock->store_id = $store->id;
        $stock->save();

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
        $retailer = User::factory()->create();
        $store = Store::factory()->create();
        $product = Product::factory()->create();

        $stock = new Stock();
        $stock->retailer_id = $retailer->id;
        $stock->store_id = $store->id;
        $stock->save();

        $item = new StockItem();
        $item->stock_id = $stock->id;
        $item->product_id = $product->id;
        $item->quantity = 5;
        $item->unit_price = 19.9;
        $item->save();

        $response = $this->put("/api/stock-items/$item->id", [
            'stock_id' => $stock->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'unit_price' => 14.9,
        ]);

        $response->assertOk();
    }
}
