<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $name
 * @property DateTime $released_at
 */
#[OA\Schema(
    schema: 'CardEdition',
    required: ['id', 'name', 'released_at'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the card edition', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the card edition', type: 'string', example: 'Base Edition 2024', nullable: false),
        new OA\Property(property: 'released_at', description: 'The release date of the card edition', type: 'string', format: 'date', nullable: false),
    ]
)]
class CardEditionResource extends JsonResource
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
            'released_at' => $this->released_at,
        ];
    }
}
