<?php

namespace App\Http\Requests\Address;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * @property string $address_name
 * @property string $recipient_name
 * @property string $street
 * @property string $postal_code
 * @property string $locality
 * @property string $country
 */
#[OA\Schema(
    schema: 'AddressEditInput',
    required: ['name'],
    properties: [
        new OA\Property(property: 'address_name', description: 'A descriptive name of the address', type: 'string', example: 'Home', nullable: false),
        new OA\Property(property: 'recipient_name', description: 'The name of the person or service of the address', type: 'string', example: 'John Doe', nullable: false),
        new OA\Property(property: 'street', description: 'The street address', type: 'string', example: '1600 Amphitheatre Pkwy', nullable: false),
        new OA\Property(property: 'postal_code', description: 'The postal code', type: 'string', example: '94043', nullable: false),
        new OA\Property(property: 'locality', description: 'The locality in which the street address is', type: 'string', example: 'Mountain View', nullable: false),
        new OA\Property(property: 'country', description: 'The country', type: 'string', example: 'USA', nullable: false),
    ]
)]
#[OA\RequestBody(
    description: 'Request body for creating or updating an address',
    required: true,
    content: [
        new OA\JsonContent(ref: '#/components/schemas/AddressEditInput'),
    ]
)]
class AddressCreateRequest extends FormRequest
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
            'address_name' => 'required|string',
            'recipient_name' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|string',
            'locality' => 'required|string',
            'country' => 'required|string',
        ];
    }
}
