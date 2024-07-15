<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
#[OA\Schema(
    schema: 'User',
    required: ['id', 'name', 'email'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the user', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the user', type: 'string', nullable: false),
        new OA\Property(property: 'email', description: 'The email address of the user', type: 'string', format: 'email', nullable: false),
        new OA\Property(property: 'addresses', description: 'The addresses linked to the user', type: 'array', items: new OA\Items(ref: '#/components/schemas/Address'), nullable: false),
    ]
)]
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'addresses' => AddressResource::collection($this->whenLoaded('address')),
        ];
    }
}
