<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $address_name
 * @property string $recipient_name
 * @property string $street
 * @property string $postal_code
 * @property string $locality
 * @property string $country
 */
#[OA\Schema(
    schema: 'Address',
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the address', type: 'integer', nullable: false),
        new OA\Property(property: 'address_name', description: 'A descriptive name of the address', type: 'string', example: 'Home', nullable: false),
        new OA\Property(property: 'recipient_name', description: 'The name of the person or service of the address', type: 'string', example: 'John Doe', nullable: false),
        new OA\Property(property: 'street', description: 'The street address', type: 'string', example: '1600 Amphitheatre Pkwy', nullable: false),
        new OA\Property(property: 'postal_code', description: 'The postal code', type: 'string', example: '94043', nullable: false),
        new OA\Property(property: 'locality', description: 'The locality in which the street address is', type: 'string', example: 'Mountain View', nullable: false),
        new OA\Property(property: 'country', description: 'The country', type: 'string', example: 'USA', nullable: false),
        new OA\Property(property: 'links', description: 'Links related to the address', properties: [
            new OA\Property(property: 'edit', description: 'Link to edit the address', type: 'string', format: 'url'),
        ], type: 'object', nullable: false),
    ]
)]
class AddressResource extends JsonResource
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
            'address_name' => $this->address_name,
            'recipient_name' => $this->recipient_name,
            'street' => $this->street,
            'postal_code' => $this->postal_code,
            'locality' => $this->locality,
            'country' => $this->country,
            'links' => [
                'edit' => route('addresses.update', [$this->id]),
            ],
        ];
    }
}
