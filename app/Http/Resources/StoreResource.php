<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property string $name
 */
#[OA\Schema(
    schema: 'Store',
    required: ['data'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the store', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the store', type: 'string', nullable: false),
    ]
)]
class StoreResource extends JsonResource
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
        ];
    }
}
