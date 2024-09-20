<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use App\Enums\CardGame;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property float $price
 */
class Product extends Model
{
    use HasFactory, Searchable, Filterable;

    public function local_properties(): HasMany
    {
        return $this->hasMany(ProductLocalProperties::class);
    }

    public function boardgame_properties(): BelongsTo
    {
        return $this->belongsTo(BoardgameProperties::class);
    }

    public function card_properties_magic(): BelongsTo
    {
        return $this->belongsTo(CardPropertiesMagic::class);
    }

    public function card_properties_yugioh(): BelongsTo
    {
        return $this->belongsTo(CardPropertiesYugioh::class);
    }

    public function card_properties_fab(): BelongsTo
    {
        return $this->belongsTo(CardPropertiesFab::class);
    }

    public function card_properties_lorcana(): BelongsTo
    {
        return $this->belongsTo(CardPropertiesLorcana::class);
    }

    public function card_release(): BelongsTo
    {
        return $this->belongsTo(CardRelease::class);
    }

    public function card_print_state(): BelongsTo
    {
        return $this->belongsTo(CardPrintState::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    protected function casts(): array
    {
        return [
            'product_type' => ProductType::class,
            'card_game' => CardGame::class,
        ];
    }
}
