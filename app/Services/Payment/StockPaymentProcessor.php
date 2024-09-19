<?php

namespace App\Services\Payment;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Exceptions\NotImplementedException;
use App\Models\Stock;
use App\Models\StoreCreditHistory;

final readonly class StockPaymentProcessor
{
    /**
     * @throws NotImplementedException If the retailer is using an unsupported payment mode
     */
    public function processPayment(Stock $stock): void
    {               
        if ($stock->payment_mode === PaymentMode::STORE_CREDIT) {
            $retailer = $stock->retailer;

            $storeCreditHistory = new StoreCreditHistory;
            $storeCreditHistory->comment = "Stock #{$stock->id}";
            $storeCreditHistory->credit = $stock->total_price();
            $storeCreditHistory->customer_id = $retailer->id;

            $storeCreditHistory->save();

            $stock->payment_status = PaymentStatus::PAYMENT_ACCEPTED;
            $stock->save();
        }

        if ($stock->payment_mode === PaymentMode::CASH) {
            $stock->payment_status = PaymentStatus::PAYMENT_ACCEPTED;
            $stock->save();
        }

        if ($stock->payment_mode === PaymentMode::PAYPAL) {
            throw new NotImplementedException('Paypal payment is not implemented yet');
        }
    }
}
