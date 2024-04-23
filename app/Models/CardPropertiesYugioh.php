<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardPropertiesYugioh extends Model
{
    public $table = 'card_properties_yugioh';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    use HasFactory;
}
