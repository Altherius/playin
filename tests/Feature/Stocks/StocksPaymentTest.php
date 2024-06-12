<?php

namespace Tests\Feature\Stocks;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\User;
use Tests\TestCase;

class StocksPaymentTest extends TestCase
{
    public function test_stock_payment_with_store_credit()
    {
        $retailer = User::factory()->create();
        $stock = Stock::factory()->validated()->create();
        StockItem::factory()->for($stock)->create();

        $stock->retailer_id = $retailer->id;
        $stock->payment_mode = PaymentMode::STORE_CREDIT;
        $stock->payment_status = PaymentStatus::PROCESSING_PAYMENT;
        $stock->save();

        $retailer->refresh();

        $this->assertEquals(PaymentStatus::PAYMENT_ACCEPTED, $stock->payment_status);
        $this->assertEquals($stock->total_price(), $retailer->store_credit);
    }
}
