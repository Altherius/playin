<?php

namespace Stocks;

use App\Models\Product;
use App\Models\ProductLocalProperties;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Store;
use App\Models\User;
use Tests\TestCase;

class StocksValidationTest extends TestCase
{
    public function test_stock_validation_updates_available_quantity()
    {
        $retailer = User::factory()->create();
        $store = Store::factory()->create();
        $product = Product::factory()->create();

        $stock = new Stock();
        $stock->retailer_id = $retailer->id;
        $stock->store_id = $store->id;
        $stock->validated = false;
        $stock->save();

        $item = new StockItem();
        $item->stock_id = $stock->id;
        $item->product_id = $product->id;
        $item->quantity = 3;
        $item->unit_price = 19.9;
        $item->save();

        $stock->validated = true;

        $stock->save();

        $localProperties = ProductLocalProperties::where([
            'product_id' => $item->product_id,
            'store_id' => $item->stock->store_id,
        ])->first();

        $this->assertEquals($localProperties->available_quantity, $item->quantity);
    }
}
