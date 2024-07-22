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
use OpenApi\Attributes as OA;

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
 * @property ?Media $image
 */
#[OA\Schema(
    schema: 'Product',
    required: ['id', 'name', 'card_game', 'slug', 'price', 'links', 'image_url'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the product', type: 'integer', nullable: false),
        new OA\Property(property: 'name', description: 'The name of the product', type: 'string', nullable: false),
        new OA\Property(property: 'image_url', description: 'The URL of the product image', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'card_game', description: 'The card game related to the product', type: 'string', enum: ['magic', 'yugioh', 'fab', 'lorcana'], nullable: false),
        new OA\Property(property: 'slug', description: 'The slug of the product', type: 'string', nullable: false),
        new OA\Property(property: 'price', description: 'The default price of the product', type: 'float', minimum: 0, nullable: false),
        new OA\Property(
            property: 'card_print_state',
            ref: '#/components/schemas/CardPrintState',
            description: 'The card print state of the product, present only if the product is a card',
            nullable: false
        ),
        new OA\Property(
            property: 'card_release',
            ref: '#/components/schemas/CardRelease',
            description: 'The card release of the product, present only if the product is a card',
            nullable: false
        ),
        new OA\Property(
            property: 'card_properties',
            description: 'The card properties of the product, present only if the product is a card',
            nullable: false,
            oneOf: [
                new OA\Schema(ref: '#/components/schemas/CardPropertiesMagic'),
                new OA\Schema(ref: '#/components/schemas/CardPropertiesYugioh'),
                new OA\Schema(ref: '#/components/schemas/CardPropertiesFab'),
                new OA\Schema(ref: '#/components/schemas/CardPropertiesLorcana'),
            ]
        ),
        new OA\Property(
            property: 'boardgame_properties',
            ref: '#/components/schemas/BoardgameProperties',
            description: 'The board-game properties of the product, present only if the product is a board-game',
            nullable: false
        ),
        new OA\Property(property: 'links', description: 'Links related to the product', properties: [
            new OA\Property(property: 'show', description: 'Link to show the product', type: 'string', format: 'url'),
        ], type: 'object', nullable: false),
    ]
)]
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
            'image_url' => $this->image ? str_replace('/public', '', asset('media/'.$this->image->file_path)) : null,
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
