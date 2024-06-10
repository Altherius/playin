<?php

namespace App\Http\Resources;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\StockItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property User $retailer
 * @property bool $validated
 * @property bool $sent
 * @property bool received
 * @property Collection<StockItem> $items
 * @property PaymentStatus $payment_status
 * @property PaymentMode $payment_mode
 * @property Address $address
 */
class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'retailer' => route('users.show', [$this->retailer->id]),
            'validated' => $this->validated,
            'sent' => $this->sent,
            'received' => $this->received,
            'payment_status' => $this->payment_status,
            'payment_mode' => $this->payment_mode,
            'total_price' => $this->items->reduce(fn ($carry, $item) => $carry + ($item->quantity * $item->unit_price), 0),
            'items' => StockItemResource::collection($this->items),
            'address' => new AddressResource($this->address),
            'links' => [
                'show' => route('stocks.show', [$this->id]),
            ],
        ];
    }
}
