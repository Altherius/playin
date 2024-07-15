<?php

namespace App\Http\Requests\Stock;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property int $retailer_id
 * @property int $store_id
 */
#[OA\Schema(
    schema: 'StockCreateInput',
    required: ['retailer_id', 'store_id'],
    properties: [
        new OA\Property(property: 'customer_id', description: 'The retailer linked to the stock', type: 'integer', nullable: false),
        new OA\Property(property: 'store_id', description: 'The store linked to the order', type: 'integer', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating a stock',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/OrderCreateInput'),
    ]
)]
class StockCreateRequest extends FormRequest
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
            'retailer_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
        ];
    }
}
