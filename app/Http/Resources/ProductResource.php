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
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property CardGame $card_game
 * @property ProductType $product_type
 * @property string $slug
 * @property string $price
 * @property ?CardPropertiesMagic $card_properties_magic
 * @property ?CardPropertiesYugioh $card_properties_yugioh
 * @property ?CardPropertiesFab $card_properties_fab
 * @property ?CardPropertiesLorcana $card_properties_lorcana
 * @property ?BoardgameProperties $boardgame_properties
 * @property ?CardPrintState $card_print_state
 * @property ?CardRelease $card_release
 * @property ?Category $category
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
            'card_game' => $this->card_game,
            'slug' => $this->slug,
            'price' => (float) $this->price,
            'links' => [
                'show' => route('products.show', [$this->id]),
            ],
        ];

        if ($this->category) {
            $rootCategory = $this->category;
            $properties['breadcrumb'] = [];

            do {
                array_unshift($properties['breadcrumb'], new CategoryResource($rootCategory));
                $rootCategory = $rootCategory->parent;
            } while ($rootCategory?->parent);

            array_unshift($properties['breadcrumb'], new CategoryResource($rootCategory));
        }

        if ($this->product_type === ProductType::CARD) {

            $properties['card_properties'] = match ($this->card_game) {
                CardGame::MAGIC => new CardPropertiesMagicResource($this->whenLoaded('card_properties_magic')),
                CardGame::YUGIOH => new CardPropertiesYugiohResource($this->whenLoaded('card_properties_yugioh')),
                CardGame::FAB => new CardPropertiesFabResource($this->whenLoaded('card_properties_fab')),
                CardGame::LORCANA => new CardPropertiesLorcanaResource($this->whenLoaded('card_properties_lorcana')),
            };

            $properties['card_print_state'] = new CardPrintStateResource($this->whenLoaded('card_print_state'));
            $properties['card_release'] = new CardReleaseResource($this->whenLoaded('card_release'));
        }

        if ($this->product_type === ProductType::BOARDGAME) {
            $properties['boardgame_properties'] = new BoardgamePropertiesResource($this->whenLoaded('boardgame_properties'));
        }

        return $properties;
    }
}
