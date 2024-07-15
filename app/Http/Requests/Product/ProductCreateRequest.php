<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property string $name
 * @property float $price
 */
#[OA\Schema(
    schema: 'ProductEditInput',
    required: ['name', 'price'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the product', type: 'string', nullable: false),
        new OA\Property(property: 'price', description: 'The default price of the product', type: 'float', minimum: 0, nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating or updating a product',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/ProductEditInput'),
    ]
)]
class ProductCreateRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required|gte:0',
        ];
    }
}
