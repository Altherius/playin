<?php

namespace App\Listeners;

use App\Enums\PaymentStatus;
use App\Events\StockPaymentProcessing;
use App\Events\StockUpdated;
use App\Events\StockValidated;

class StockUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(StockUpdated $event): void
    {
        if ($event->stock->isDirty('validated') && $event->stock->validated) {
            StockValidated::dispatch($event->stock);
        }

        if ($event->stock->isDirty('payment_status') && $event->stock->payment_status === PaymentStatus::PROCESSING_PAYMENT) {
            StockPaymentProcessing::dispatch($event->stock);
        }
    }
}
