<?php

namespace App\Listeners;

use App\Events\StockPaymentProcessing;
use App\Exceptions\NotImplementedException;
use App\Services\Payment\StockPaymentProcessor;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

readonly class ProcessStockPayment
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly StockPaymentProcessor $paymentProcessor)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockPaymentProcessing $event): void
    {
        try {
            $this->paymentProcessor->processPayment($event->stock);
        } catch (NotImplementedException $exception) {
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }
    }
}
