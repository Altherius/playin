<?php

namespace App\Services\Payment;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Exceptions\InsufficientCreditException;
use App\Exceptions\NotImplementedException;
use App\Models\Order;
use App\Models\StoreCreditHistory;

final readonly class OrderPaymentProcessor
{
    /**
     * @throws NotImplementedException If the customer is using an unsupported payment mode
     * @throws InsufficientCreditException If the customer does not have enough store credit to pay the order
     */
    public function processPayment(Order $order): void
    {
        if ($order->payment_mode === PaymentMode::STORE_CREDIT) {
            $customer = $order->customer;
            if ($customer->store_credit >= $order->total_price()) {
                $storeCreditHistory = new StoreCreditHistory;
                $storeCreditHistory->comment = "Order #{$order->id}";
                $storeCreditHistory->credit = -$order->total_price();
                $storeCreditHistory->customer_id = $customer->id;

                $storeCreditHistory->save();

                $order->payment_status = PaymentStatus::PAYMENT_ACCEPTED;
                $order->save();
            } else {
                throw new InsufficientCreditException("Trying to pay €{$order->total_price()} with store credit, but customer only has €{$customer->store_credit} remaining");
            }
        }

        if ($order->payment_mode === PaymentMode::CASH) {
            $order->payment_status = PaymentStatus::PAYMENT_ACCEPTED;
            $order->save();
        }

        if ($order->payment_mode === PaymentMode::PAYPAL) {
            throw new NotImplementedException('Paypal payment is not implemented yet');
        }
    }
}
