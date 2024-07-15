<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CardPropertiesLorcana',
    description: 'Card properties of a Lorcana trading card',
    required: ['name', 'cost', 'can_be_ink', 'type_line', 'rules_text', 'power', 'toughness', 'lore'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the card', type: 'string', nullable: false),
        new OA\Property(property: 'cost', description: 'The cost of the card', type: 'integer', nullable: false),
        new OA\Property(property: 'can_be_ink', description: 'Can the card be played as ink?', type: 'boolean', nullable: false),
        new OA\Property(property: 'type_line', description: 'The type line of the card', type: 'string', nullable: false),
        new OA\Property(property: 'rules_text', description: 'The rules text of the card', type: 'string', nullable: false),
        new OA\Property(property: 'attack', description: 'The attack of the card', type: 'integer', nullable: true),
        new OA\Property(property: 'defense', description: 'The defense of the card', type: 'integer', nullable: true),
        new OA\Property(property: 'lore', description: 'The lore value of the card', type: 'integer', nullable: true),
    ]
)]
class CardPropertiesLorcanaResource extends JsonResource
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
