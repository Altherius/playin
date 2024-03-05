<?php

namespace Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductLocalProperties;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Store;
use App\Models\User;
use Tests\TestCase;

class OrdersValidationTest extends TestCase
{
    public function test_order_validation_updates_available_quantity()
    {
        $customer = User::factory()->create();
        $store = Store::factory()->create();
        $product = Product::factory()->create();

        $order = new Order();
        $order->customer_id = $customer->id;
        $order->store_id = $store->id;
        $order->validated = false;
        $order->save();

        $item = new OrderItem();
        $item->order_id = $order->id;
        $item->product_id = $product->id;
        $item->quantity = 3;
        $item->unit_price = 19.9;
        $item->save();

        $localProperties = new ProductLocalProperties();
        $localProperties->product_id = $item->product_id;
        $localProperties->store_id = $store->id;
        $localProperties->available_quantity = 10;
        $localProperties->save();

        $order->validated = true;
        $order->save();

        $localProperties = ProductLocalProperties::firstOrCreate([
            'product_id' => $item->product_id,
            'store_id' => $store->id,
        ]);


        $this->assertEquals($localProperties->available_quantity, 7);
    }
}
