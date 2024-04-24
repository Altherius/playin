<?php

namespace App\Http\Resources;

use App\Enums\CardGame;
use App\Enums\ProductType;
use App\Models\BoardgameProperties;
use App\Models\CardPrintState;
use App\Models\CardPropertiesFab;
use App\Models\CardPropertiesLorcana;
use App\Models\CardPropertiesMagic;
use App\Models\CardPropertiesYugioh;
use App\Models\CardRelease;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $card_game
 * @property string $product_type
 * @property string $slug
 * @property string $price
 * @property ?CardPropertiesMagic $card_properties_magic
 * @property ?CardPropertiesYugioh $card_properties_yugioh
 * @property ?CardPropertiesFab $card_properties_fab
 * @property ?CardPropertiesLorcana $card_properties_lorcana
 * @property ?BoardgameProperties $boardgame_properties
 * @property ?CardPrintState $card_print_state
 * @property ?CardRelease $card_release
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
            'card_game' => $this->card_game !== null ? CardGame::from($this->card_game)->name() : null,
            'slug' => $this->slug,
            'price' => (float) $this->price,
            'links' => [
                'show' => route('products.show', [$this->id]),
            ],
        ];

        if ($this->product_type === ProductType::CARD->value) {

            $properties['card_properties'] = match ($this->card_game) {
                CardGame::MAGIC->value => new CardPropertiesMagicResource($this->whenLoaded('card_properties_magic')),
                CardGame::YUGIOH->value => new CardPropertiesYugiohResource($this->whenLoaded('card_properties_yugioh')),
                CardGame::FAB->value => new CardPropertiesFabResource($this->whenLoaded('card_properties_fab')),
                CardGame::LORCANA->value => new CardPropertiesLorcanaResource($this->whenLoaded('card_properties_lorcana')),
                default => null
            };

            $properties['card_print_state'] = new CardPrintStateResource($this->whenLoaded('card_print_state'));
            $properties['card_release'] = new CardReleaseResource($this->whenLoaded('card_release'));
        }

        if ($this->product_type === ProductType::BOARDGAME->value) {
            $properties['boardgame_properties'] = new BoardgamePropertiesResource($this->whenLoaded('boardgame_properties'));
        }

        return $properties;
    }
}
