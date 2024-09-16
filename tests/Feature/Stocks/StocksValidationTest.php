<?php

namespace Tests\Feature\Stocks;

use App\Models\ProductLocalProperties;
use App\Models\StockItem;
use Tests\TestCase;

class StocksValidationTest extends TestCase
{
    public function test_stock_validation_updates_available_quantity()
    {
        $item = StockItem::factory()->create();
        $stock = $item->stock;

        $stock->validated = true;
        $stock->save();

        $localProperties = ProductLocalProperties::where([
            'product_id' => $item->product_id,
            'store_id' => $item->stock->store_id,
        ])->first();

        $this->assertEquals($localProperties->available_quantity, $item->quantity);
    }
}
