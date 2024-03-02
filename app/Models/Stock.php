<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    public function items(): HasMany
    {
        return $this->hasMany(StockItem::class);
    }

    public function retailer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
