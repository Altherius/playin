<?php

namespace App\Listeners;

use App\Enums\PaymentStatus;
use App\Events\OrderPaymentProcessing;
use App\Events\OrderUpdated;
use App\Events\OrderValidated;

class OrderUpdatedListener
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
    public function handle(OrderUpdated $event): void
    {
        if ($event->order->isDirty('validated') && $event->order->validated) {
            OrderValidated::dispatch($event->order);
        }

        if ($event->order->isDirty('payment_status') && $event->order->payment_status === PaymentStatus::PROCESSING_PAYMENT) {
            OrderPaymentProcessing::dispatch($event->order);
        }
    }
}
