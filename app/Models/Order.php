<?php

namespace App\Models;

use App\Events\OrderValidated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property OrderItem[] $items
 * @property Store $store
 * @property int $store_id
 * @property User $customer
 * @property int $customer_id
 */
class Order extends Model
{
    use HasFactory;

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    protected $dispatchesEvents = [
        'updating' => OrderValidated::class,
    ];
}
