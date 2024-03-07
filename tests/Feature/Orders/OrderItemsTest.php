<?php

namespace Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_items_can_be_created(): void
    {
        $customer = User::factory()->create();
        $store = Store::factory()->create();
        $product = Product::factory()->create();

        $order = new Order();
        $order->customer_id = $customer->id;
        $order->store_id = $store->id;
        $order->save();

        $response = $this->post('/api/order-items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'unit_price' => 19.9,
        ]);

        $response->assertOk();
    }

    public function test_order_items_can_be_updated(): void
    {
        $item = OrderItem::factory()->create();

        $response = $this->put("/api/order-items/$item->id", [
            'order_id' => $item->order_id,
            'product_id' => $item->product_id,
            'quantity' => 3,
            'unit_price' => 14.9,
        ]);

        $response->assertOk();
    }
}
