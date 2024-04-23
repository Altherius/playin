<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $mana_cost
 * @property string $type_line
 * @property string $rules_text
 * @property ?float $power
 * @property ?float $toughness
 */
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
