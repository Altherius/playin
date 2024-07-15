<?php

namespace App\Http\Requests\StockItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property int $stock_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 */
#[OA\Schema(
    schema: 'StockItemEditInput',
    required: ['stock_id', 'product_id', 'unit_price'],
    properties: [
        new OA\Property(property: 'stock_id', description: 'The stock linked to the stock item', type: 'integer', nullable: false),
        new OA\Property(property: 'product_id', description: 'The product linked to the stock item', type: 'integer', nullable: false),
        new OA\Property(property: 'quantity', description: 'The quantity ordered', type: 'integer', minimum: 1, nullable: false),
        new OA\Property(property: 'unit_price', description: 'The unit price of the product in the stock', type: 'float', minimum: 0, nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating or updating a stock item',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/StockItemEditInput'),
    ]
)]
class StockItemCreateRequest extends FormRequest
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
            'stock_id' => 'required|exists:stocks,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'gte:1',
            'unit_price' => 'required|min:0',
        ];
    }
}
