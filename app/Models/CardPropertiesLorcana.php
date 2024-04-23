<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardPropertiesLorcana extends Model
{
    public $table = 'card_properties_lorcana';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    use HasFactory;
}
