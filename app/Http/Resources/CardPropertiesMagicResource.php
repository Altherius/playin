<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $name
 * @property string $mana_cost
 * @property string $type_line
 * @property string $rules_text
 * @property ?float $power
 * @property ?float $toughness
 */
#[OA\Schema(
    schema: 'CardPropertiesMagic',
    description: 'Card properties of a Magic trading card',
    required: ['id', 'name', 'mana_cost', 'type_line', 'rules_text', 'power', 'toughness'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the card', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the card', type: 'string', nullable: false),
        new OA\Property(property: 'mana_cost', description: 'The encoded mana cost of the card', type: 'string', nullable: true),
        new OA\Property(property: 'type_line', description: 'The type line of the card', type: 'string', nullable: false),
        new OA\Property(property: 'rules_text', description: 'The rules text of the card', type: 'string', nullable: false),
        new OA\Property(property: 'power', description: 'The power of the card', type: 'integer', nullable: true),
        new OA\Property(property: 'toughness', description: 'The toughness of the card', type: 'integer', nullable: true),
    ]
)]
class CardPropertiesMagicResource extends JsonResource
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
            'mana_cost' => $this->mana_cost,
            'type_line' => $this->type_line,
            'rules_text' => $this->rules_text,
            'power' => $this->power,
            'toughness' => $this->toughness,
        ];
    }
}
