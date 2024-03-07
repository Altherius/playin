<?php

namespace App\Http\Resources;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property bool $validated
 * @property User $customer
 * @property Collection<OrderItem> $items
 */
class OrderResource extends JsonResource
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
            'customer' => route('users.show', [$this->customer]),
            'validated' => $this->validated,
            'total_price' => round($this->items->reduce(fn ($carry, $item) => $carry + ($item->quantity * $item->unit_price), 0), 2),
            'items' => OrderItemResource::collection($this->items),
            'address' => new AddressResource($this->address),
            'links' => [
                'show' => route('orders.show', [$this->id]),
            ],
        ];
    }
}
