<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CardPropertiesFab',
    description: 'Card properties of a Flesh & Blood trading card',
    required: ['name', 'resource_cost', 'pitch', 'type_line', 'rules_text', 'attack', 'defense'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the card', type: 'string', nullable: false),
        new OA\Property(property: 'resource_cost', description: 'The resource cost of the card', type: 'integer', nullable: false),
        new OA\Property(property: 'pitch', description: 'The pitch of the card', type: 'integer', nullable: false),
        new OA\Property(property: 'type_line', description: 'The type line of the card', type: 'string', nullable: false),
        new OA\Property(property: 'rules_text', description: 'The rules text of the card', type: 'string', nullable: false),
        new OA\Property(property: 'attack', description: 'The attack of the card', type: 'integer', nullable: true),
        new OA\Property(property: 'defense', description: 'The defense of the card', type: 'integer', nullable: true),
    ]
)]
class CardPropertiesFabResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
