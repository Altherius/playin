<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardRelease extends Model
{
    use Filterable, HasFactory;

    public function card_edition(): BelongsTo
    {
        return $this->belongsTo(CardEdition::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
