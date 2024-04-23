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
 * @property ?int $card_properties_magic_id
 * @property ?int $card_properties_yugioh_id
 * @property ?int $card_properties_fab_id
 * @property ?int $card_properties_lorcana_id
 * @property ?int $boardgame_properties_id
 * @property ?int $card_print_state_id
 * @property ?int $card_release_id
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
                CardGame::MAGIC->value => new CardPropertiesMagicResource(CardPropertiesMagic::find($this->card_properties_magic_id)),
                CardGame::YUGIOH->value => new CardPropertiesYugiohResource(CardPropertiesYugioh::find($this->card_properties_yugioh_id)),
                CardGame::FAB->value => new CardPropertiesFabResource(CardPropertiesFab::find($this->card_properties_fab_id)),
                CardGame::LORCANA->value => new CardPropertiesLorcanaResource(CardPropertiesLorcana::find($this->card_properties_lorcana_id)),
                default => null
            };

            $properties['card_print_state'] = new CardPrintStateResource(CardPrintState::find($this->card_print_state_id));
            $properties['card_release'] = new CardReleaseResource(CardRelease::find($this->card_release_id));

            $properties['name'] = $properties['card_properties']['name'] .
                ' - ' . $properties['card_release']['edition'] .
                ' ' . "({$properties['card_print_state']['language']} {$properties['card_print_state']['grading']})";
            ;
        }

        if ($this->product_type === ProductType::BOARDGAME->value) {
            $properties['boardgame_properties'] = new BoardgamePropertiesResource(BoardgameProperties::find($this->boardgame_properties_id));
        }

        return $properties;
    }
}
