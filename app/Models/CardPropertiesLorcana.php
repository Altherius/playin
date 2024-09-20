<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardPropertiesLorcana extends Model
{
    use Filterable;

    public $table = 'card_properties_lorcana';

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    use HasFactory;
}
