<?php

namespace App\Listeners;

use App\Events\OrderPaymentProcessing;
use App\Exceptions\InsufficientCreditException;
use App\Exceptions\NotImplementedException;
use App\Services\Payment\OrderPaymentProcessor;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

readonly class ProcessOrderPayment
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly OrderPaymentProcessor $paymentProcessor)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPaymentProcessing $event): void
    {
        try {
            $this->paymentProcessor->processPayment($event->order);
        } catch (InsufficientCreditException|NotImplementedException $exception) {
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }
    }
}
