<?php

namespace App\Listeners;

use App\Events\StockValidated;
use App\Models\ProductLocalProperties;

class StockValidatedListener
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
    public function handle(StockValidated $event): void
    {
        if ($event->stock->getAttributes() && ! $event->stock->getOriginal()['validated']) {
            foreach ($event->stock->items as $item) {
                $localProperties = ProductLocalProperties::firstOrCreate([
                    'product_id' => $item->product_id,
                    'store_id' => $event->stock->store_id,
                ]);

                $localProperties->available_quantity += $item->quantity;
                $localProperties->save();
            }
        }
    }
}
