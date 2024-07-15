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
use OpenApi\Attributes as OA;

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
#[OA\Schema(
    schema: 'Stock',
    required: ['id', 'retailer', 'validated', 'sent'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the stock', type: 'integer', nullable: false),
        new OA\Property(property: 'retailer', ref: '#/components/schemas/User', description: 'The stock retailer', nullable: false),
        new OA\Property(property: 'validated', description: 'Is the stock validated?', type: 'boolean', nullable: false),
        new OA\Property(property: 'sent', description: 'Is the stock sent?', type: 'boolean', nullable: false),
        new OA\Property(property: 'received', description: 'Is the stock received?', type: 'boolean', nullable: false),
        new OA\Property(
            property: 'payment_status',
            description: 'The payment status of the stock',
            type: 'string',
            enum: [PaymentStatus::AWAITING_PAYMENT, PaymentStatus::PROCESSING_PAYMENT, PaymentStatus::PAYMENT_ACCEPTED, PaymentStatus::PAYMENT_REJECTED],
            nullable: false
        ),
        new OA\Property(
            property: 'payment_mode',
            description: 'The payment mode of the stock',
            type: 'string',
            enum: [PaymentMode::CASH, PaymentMode::STORE_CREDIT, PaymentMode::PAYPAL],
            nullable: true
        ),
        new OA\Property(property: 'total_price', description: 'The total price of the stock', type: 'float', minimum: 0, nullable: false),
        new OA\Property(property: 'items', description: 'The items in the stock', type: 'array', items: new OA\Items(ref: '#/components/schemas/StockItem'), nullable: false),
        new OA\Property(property: 'address', ref: '#/components/schemas/Address', description: 'The address linked to the stock', nullable: true),
        new OA\Property(property: 'links', description: 'Links related to the stock', properties: [
            new OA\Property(property: 'show', description: 'Link to show the stock', type: 'string', format: 'url'),
        ], type: 'object', nullable: false),
    ]
)]
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
