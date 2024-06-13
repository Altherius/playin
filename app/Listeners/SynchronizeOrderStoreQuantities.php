<?php

namespace App\Listeners;

use App\Events\OrderValidated;
use App\Models\ProductLocalProperties;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SynchronizeOrderStoreQuantities
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderValidated $event): void
    {
        foreach ($event->order->items as $item) {
            $localProperties = ProductLocalProperties::firstOrCreate([
                'product_id' => $item->product_id,
                'store_id' => $event->order->store_id,
            ]);

            if ($localProperties->available_quantity < $item->quantity) {
                throw new UnprocessableEntityHttpException(
                    sprintf(
                        'Trying to order %sx %s but only %s remaining in %s',
                        $item->quantity,
                        $item->product->name,
                        $localProperties->available_quantity,
                        $localProperties->store->name
                    )
                );
            }

            $localProperties->available_quantity -= $item->quantity;
            $localProperties->save();
        }
    }
}
