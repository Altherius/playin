<?php

namespace App\Http\Resources;

use App\Models\CardEdition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property CardEdition $card_edition
 * @property string $collection_number
 * @property string $artist
 */
#[OA\Schema(
    schema: 'CardRelease',
    required: ['id', 'edition', 'collection_number', 'artist'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the card release', type: 'integer', nullable: false),
        new OA\Property(property: 'edition', ref: '#/components/schemas/CardEdition', description: 'The edition linked to this release'),
        new OA\Property(property: 'collection_number', description: 'A string identifying the card in the release', type: 'string', example: '001', nullable: false),
        new OA\Property(property: 'artist', description: 'The artist who did the art of the card in the release', type: 'string', example: 'John Doe', nullable: false),
        new OA\Property(property: 'products', description: 'The products linked to this card release', type: 'string', nullable: false),
    ]
)]
class CardReleaseResource extends JsonResource
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
            'edition' => new CardEditionResource($this->card_edition),
            'collection_number' => $this->collection_number,
            'artist' => $this->artist,
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
