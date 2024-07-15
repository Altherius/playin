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
use OpenApi\Attributes as OA;

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
#[OA\Schema(
    schema: 'Order',
    required: ['id', 'customer', 'validated', 'sent', 'received', 'payment_status', 'payment_mode', 'total_price', 'links'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the order', type: 'integer', nullable: false),
        new OA\Property(property: 'customer', ref: '#/components/schemas/User', description: 'The order customer', nullable: false),
        new OA\Property(property: 'validated', description: 'Is the order validated?', type: 'boolean', nullable: false),
        new OA\Property(property: 'sent', description: 'Is the order sent?', type: 'boolean', nullable: false),
        new OA\Property(property: 'received', description: 'Is the order received?', type: 'boolean', nullable: false),
        new OA\Property(
            property: 'payment_status',
            description: 'The payment status of the order',
            type: 'string',
            enum: [PaymentStatus::AWAITING_PAYMENT, PaymentStatus::PROCESSING_PAYMENT, PaymentStatus::PAYMENT_ACCEPTED, PaymentStatus::PAYMENT_REJECTED],
            nullable: false
        ),
        new OA\Property(
            property: 'payment_mode',
            description: 'The payment mode of the order',
            type: 'string',
            enum: [PaymentMode::CASH, PaymentMode::STORE_CREDIT, PaymentMode::PAYPAL],
            nullable: true
        ),
        new OA\Property(property: 'total_price', description: 'The total price of the order', type: 'float', minimum: 0, nullable: false),
        new OA\Property(property: 'items', description: 'The items in the order', type: 'array', items: new OA\Items(ref: '#/components/schemas/OrderItem'), nullable: false),
        new OA\Property(property: 'address', ref: '#/components/schemas/Address', description: 'The address linked to the order', nullable: true),
        new OA\Property(property: 'links', description: 'Links related to the order', required: ['show'], properties: [
            new OA\Property(property: 'show', description: 'Link to show the order', type: 'string', format: 'url'),
        ], type: 'object', nullable: false),
    ]
)]
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
