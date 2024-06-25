<?php

namespace App\Listeners;

use App\Events\StockUpdated;
use App\Models\ProductLocalProperties;

class SynchronizeStockStoreQuantities
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(StockUpdated $event): void
    {
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
