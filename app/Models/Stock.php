<?php

namespace App\Models;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Events\StockValidated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property bool $validated
 * @property bool $sent
 * @property bool $received
 * @property int $store_id
 * @property int $retailer_id
 */
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

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    protected $dispatchesEvents = [
        'updating' => StockValidated::class,
    ];

    protected $casts = [
        'payment_status' => PaymentStatus::class,
        'payment_mode' => PaymentMode::class
    ];
}
