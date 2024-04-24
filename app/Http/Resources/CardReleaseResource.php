<?php

namespace App\Http\Resources;

use App\Models\CardEdition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property CardEdition $card_edition
 * @property string $collection_number
 * @property string $artist
 */
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
