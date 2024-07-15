<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 */
#[OA\Schema(
    schema: 'OrderItemEditInput',
    required: ['order_id', 'product_id', 'unit_price'],
    properties: [
        new OA\Property(property: 'order_id', description: 'The order linked to the order item', type: 'integer', nullable: false),
        new OA\Property(property: 'product_id', description: 'The product linked to the order item', type: 'integer', nullable: false),
        new OA\Property(property: 'quantity', description: 'The quantity ordered', type: 'integer', minimum: 1, nullable: false),
        new OA\Property(property: 'unit_price', description: 'The unit price of the product in the order', type: 'float', minimum: 0, nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating or updating an order item',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/OrderItemEditInput'),
    ]
)]
class OrderItemCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ];
    }
}
