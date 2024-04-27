<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $store_id
 * @property Store $store
 * @property DateTime $start_time
 * @property DateTime $end_time
 * @property ?int $max_capacity
 * @property float $price
 */
class Event extends Model
{
    use HasFactory;

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
