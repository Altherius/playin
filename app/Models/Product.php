<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property float $price
 */
class Product extends Model
{
    use HasFactory;

    public function local_properties(): HasMany
    {
        return $this->hasMany(ProductLocalProperties::class);
    }

    public function card_properties_magic(): HasOne
    {
        return $this->hasOne(CardPropertiesMagic::class);
    }

    public function card_properties_yugioh(): HasOne
    {
        return $this->hasOne(CardPropertiesYugioh::class);
    }

    public function card_properties_fab(): HasOne
    {
        return $this->hasOne(CardPropertiesFab::class);
    }

    public function card_properties_lorcana(): HasOne
    {
        return $this->hasOne(CardPropertiesLorcana::class);
    }
}
