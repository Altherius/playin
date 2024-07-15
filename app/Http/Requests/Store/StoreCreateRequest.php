<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property string $name
 */
#[OA\Schema(
    schema: 'StoreEditInput',
    required: ['name'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the store', type: 'string', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating or updating a store',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/StoreEditInput'),
    ]
)]
class StoreCreateRequest extends FormRequest
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
            'name' => 'required|string',
        ];
    }
}
