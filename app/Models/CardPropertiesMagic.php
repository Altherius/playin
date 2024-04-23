<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardPropertiesMagic extends Model
{
    public $table = 'card_properties_magic';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    use HasFactory;
}
