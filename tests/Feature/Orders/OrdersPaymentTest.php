<?php

namespace Tests\Feature\Orders;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Tests\TestCase;

class OrdersPaymentTest extends TestCase
{
    public function test_order_payment_with_store_credit()
    {
        $customer = User::factory()->create();
        $order = Order::factory()->validated()->create();
        OrderItem::factory()->for($order)->create();

        $customer->store_credit = $order->total_price() + 10.0;
        $customer->save();

        $order->customer_id = $customer->id;
        $order->payment_mode = PaymentMode::STORE_CREDIT;
        $order->payment_status = PaymentStatus::PROCESSING_PAYMENT;
        $order->save();

        $customer->refresh();

        $this->assertEquals(PaymentStatus::PAYMENT_ACCEPTED, $order->payment_status);
        $this->assertEquals(10.0, $customer->store_credit);
    }

    public function test_order_payment_with_insufficient_credit()
    {
        $customer = User::factory()->create();
        $order = Order::factory()->validated()->create();
        OrderItem::factory()->for($order)->create();

        $order->customer_id = $customer->id;
        $order->payment_mode = PaymentMode::STORE_CREDIT;
        $order->payment_status = PaymentStatus::PROCESSING_PAYMENT;

        $this->expectException(UnprocessableEntityHttpException::class);
        $order->save();
    }
}
