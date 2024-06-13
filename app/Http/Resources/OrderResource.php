<?php

namespace App\Http\Resources;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property bool $validated
 * @property bool $sent
 * @property bool $received
 * @property User $customer
 * @property Collection<OrderItem> $items
 * @property Address $address
 * @property PaymentStatus $payment_status
 * @property PaymentMode $payment_mode
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
            'sent' => $this->sent,
            'received' => $this->received,
            'payment_status' => $this->payment_status,
            'payment_mode' => $this->payment_mode,
            'total_price' => round($this->items->reduce(fn ($carry, $item) => $carry + ($item->quantity * $item->unit_price), 0), 2),
            'items' => OrderItemResource::collection($this->items),
            'address' => new AddressResource($this->address),
            'links' => [
                'show' => route('orders.show', [$this->id]),
            ],
        ];
    }
}
