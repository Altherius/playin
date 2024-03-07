<?php

namespace Orders;

use App\Models\OrderItem;
use App\Models\ProductLocalProperties;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Tests\TestCase;

class OrdersValidationTest extends TestCase
{
    public function test_order_validation_updates_available_quantity()
    {
        $item = OrderItem::factory()->create();
        $order = $item->order;

        $localProperties = new ProductLocalProperties();
        $localProperties->product_id = $item->product_id;
        $localProperties->store_id = $order->store_id;
        $localProperties->available_quantity = 10;
        $localProperties->save();

        $order->validated = true;
        $order->save();

        $localProperties = ProductLocalProperties::firstOrCreate([
            'product_id' => $item->product_id,
            'store_id' => $order->store_id,
        ]);

        $this->assertEquals($localProperties->available_quantity, 10 - $item->quantity);
    }

    public function test_order_validation_without_required_quantity_is_disallowed(): void
    {
        $item = OrderItem::factory()->create();
        $order = $item->order;

        $localProperties = new ProductLocalProperties();
        $localProperties->product_id = $item->product_id;
        $localProperties->store_id = $item->order->store_id;
        $localProperties->available_quantity = $item->quantity - 1;
        $localProperties->save();

        $order->validated = true;

        $this->expectException(UnprocessableEntityHttpException::class);
        $order->save();

        $localProperties = ProductLocalProperties::firstOrCreate([
            'product_id' => $item->product_id,
            'store_id' => $order->store_id,
        ]);

        $this->assertEquals($localProperties->available_quantity, $item->quantity - 1);
    }
}
