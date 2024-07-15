<?php

namespace App\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property int $customer_id
 * @property int $store_id
 */
#[OA\Schema(
    schema: 'OrderCreateInput',
    required: ['customer_id', 'store_id'],
    properties: [
        new OA\Property(property: 'customer_id', description: 'The customer linked to the order', type: 'integer', nullable: false),
        new OA\Property(property: 'store_id', description: 'The store linked to the order', type: 'integer', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating an order',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/OrderCreateInput'),
    ]
)]
class OrderCreateRequest extends FormRequest
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
            'customer_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
        ];
    }
}
