<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardPropertiesMagic extends Model
{
    use Filterable, HasFactory;

    public $table = 'card_properties_magic';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
