<?php

namespace App\Models;

use App\Enums\GiftCardStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $barcode
 * @property float $value
 * @property GiftCardStatus $status
 */
class GiftCard extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => GiftCardStatus::class,
    ];
}
