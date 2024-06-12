<?php

namespace App\Models;

use App\Events\StoreCreditHistoryCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $comment
 * @property float $credit
 * @property int $customer_id
 */
class StoreCreditHistory extends Model
{
    use HasFactory;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function collaborator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collaborator_id');
    }

    protected function casts(): array
    {
        return [
            'credit' => 'float',
        ];
    }

    protected $dispatchesEvents = [
        'created' => StoreCreditHistoryCreated::class,
    ];
}
