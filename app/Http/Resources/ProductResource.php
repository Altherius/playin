<?php

namespace App\Http\Resources;

use App\Enums\CardGame;
use App\Models\CardPrintState;
use App\Models\CardPropertiesMagic;
use App\Models\CardRelease;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $card_game
 * @property string $slug
 * @property string $price
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $properties = [
            'id' => $this->id,
            'name' => $this->name,
            'card_game' => CardGame::from($this->card_game)->name(),
            'slug' => $this->slug,
            'price' => (float) $this->price,
            'links' => [
                'show' => route('products.show', [$this->id]),
            ],
        ];

        if ($this->card_game === CardGame::MAGIC->value) {
            $properties['card_properties'] = new CardPropertiesMagicResource(CardPropertiesMagic::find($this->card_properties_magic_id));
            $properties['card_print_state'] = new CardPrintStateResource(CardPrintState::find($this->card_print_state_id));
            $properties['card_release'] = new CardReleaseResource(CardRelease::find($this->card_release_id));
        }

        return $properties;
    }
}
