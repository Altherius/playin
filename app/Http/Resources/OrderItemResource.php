<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property Product $product
 * @property string $quantity
 * @property string $unit_price
 */
#[OA\Schema(
    schema: 'OrderItem',
    required: ['id', 'product', 'quantity', 'unit_price'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the order item', type: 'integer', nullable: false),
        new OA\Property(property: 'product', ref: '#/components/schemas/Product', description: 'The product ordered', nullable: false),
        new OA\Property(property: 'quantity', description: 'The ordered quantity', type: 'integer', minimum: 1, nullable: false),
        new OA\Property(property: 'unit_price', description: 'The unit price of the product in the order', type: 'float', minimum: 0, nullable: false),
    ]
)]
class OrderItemResource extends JsonResource
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
            'product' => new ProductResource($this->product),
            'quantity' => (int) $this->quantity,
            'unit_price' => (float) $this->unit_price,
        ];
    }
}
