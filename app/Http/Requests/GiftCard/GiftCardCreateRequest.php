<?php

namespace App\Http\Requests\GiftCard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property string $barcode
 * @property float $value
 */
#[OA\Schema(
    schema: 'GiftCardCreateInput',
    required: ['barcode', 'value'],
    properties: [
        new OA\Property(property: 'barcode', description: 'The barcode of the gift card', type: 'string', nullable: false),
        new OA\Property(property: 'value', description: 'The value of the gift card', type: 'float', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating a gift card',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/GiftCardCreateInput'),
    ]
)]
class GiftCardCreateRequest extends FormRequest
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
            'barcode' => 'required|string|size:13',
            'value' => 'required|numeric|gte:0',
        ];
    }
}
