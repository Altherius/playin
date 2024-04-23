<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CardRelease extends Model
{
    use HasFactory;

    public function card_edition(): HasOne
    {
        return $this->hasOne(CardEdition::class);
    }
}
