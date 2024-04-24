<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardPropertiesFab extends Model
{
    public $table = 'card_properties_fab';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    use HasFactory;
}
