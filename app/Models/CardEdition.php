<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardEdition extends Model
{
    public function card_releases(): HasMany
    {
        return $this->hasMany(CardRelease::class);
    }

    use HasFactory;
}
