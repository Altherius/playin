<?php

namespace App\Listeners;

use App\Events\StoreCreditHistoryCreated;

class SynchronizeStoreCreditWithHistory
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
    public function handle(StoreCreditHistoryCreated $event): void
    {

        $customer = $event->storeCreditHistory->customer;

        // As $event->storeCreditHistory->credit should be negative is this case, we are deducing from the customer's balance
        $customer->store_credit += $event->storeCreditHistory->credit;

        $customer->save();
    }
}
