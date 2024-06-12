<?php

namespace App\Models;

use App\Enums\PaymentMode;
use App\Enums\PaymentStatus;
use App\Events\StockUpdated;
use Illuminate\Database\Eloquent\Collection;
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
 * @property User $retailer
 * @property PaymentMode $payment_mode
 * @property PaymentStatus $payment_status
 * @property Collection<StockItem> $items
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

    public function total_price(): float
    {
        return round($this->items->reduce(fn ($carry, $item) => $carry + ($item->quantity * $item->unit_price), 0), 2);
    }

    protected $dispatchesEvents = [
        'updating' => StockUpdated::class,
    ];

    protected $casts = [
        'payment_status' => PaymentStatus::class,
        'payment_mode' => PaymentMode::class,
    ];
}
