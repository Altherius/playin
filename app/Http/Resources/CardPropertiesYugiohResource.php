<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CardPropertiesYugioh',
    description: 'Card properties of a Yu-Gi-Oh trading card',
    required: ['name', 'level', 'type_line', 'rules_text', 'atk', 'def'],
    properties: [
        new OA\Property(property: 'name', description: 'The name of the card', type: 'string', nullable: false),
        new OA\Property(property: 'level', description: 'The level of the card', type: 'integer', maximum: 12, minimum: 1, nullable: true),
        new OA\Property(property: 'type_line', description: 'The type line of the card', type: 'string', nullable: false),
        new OA\Property(property: 'rules_text', description: 'The rules text of the card', type: 'string', nullable: false),
        new OA\Property(property: 'atk', description: 'The attack of the card', type: 'integer', minimum: 0, nullable: true),
        new OA\Property(property: 'def', description: 'The defense of the card', type: 'integer', minimum: 0, nullable: true),
    ]
)]
class CardPropertiesYugiohResource extends JsonResource
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
