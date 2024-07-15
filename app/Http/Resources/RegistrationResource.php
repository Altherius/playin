<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property bool $paid
 */
#[OA\Schema(
    schema: 'Registration',
    required: ['id', 'user', 'event', 'paid'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the registration', type: 'integer', nullable: false),
        new OA\Property(property: 'user', ref: '#/components/schemas/User', description: 'The registered user', nullable: false),
        new OA\Property(property: 'event', ref: '#/components/schemas/Event', description: 'The related event', nullable: false),
        new OA\Property(property: 'paid', description: 'Is the registration paid?', type: 'boolean', nullable: false),
    ]
)]
class RegistrationResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'event' => new EventResource($this->whenLoaded('event')),
            'paid' => $this->paid,
        ];
    }
}
