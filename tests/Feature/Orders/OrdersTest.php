<?php

namespace Orders;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_orders_index_is_available(): void
    {
        $response = $this->get('/api/orders');
        $response->assertOk();
    }

    public function test_orders_page_is_available(): void
    {
        $customer = User::factory()->create();
        $store = Store::factory()->create();

        $order = new Order();
        $order->customer_id = $customer->id;
        $order->store_id = $store->id;
        $order->save();

        $response = $this->get("/api/orders/$order->id");
        $response->assertOk();
    }

    public function test_orders_can_be_created(): void
    {
        $customer = User::factory()->create();
        $store = Store::factory()->create();

        $response = $this->post('/api/orders', [
            'store_id' => $store->id,
            'customer_id' => $customer->id,
        ]);

        $response->assertCreated();
    }

    public function test_orders_can_be_updated(): void
    {
        $customer = User::factory()->create();
        $store = Store::factory()->create();

        $order = new Order();
        $order->customer_id = $customer->id;
        $order->store_id = $store->id;
        $order->save();

        $response = $this->put("/api/orders/$order->id", [
            'validated' => false,
        ]);

        $response->assertOk();
    }
}
