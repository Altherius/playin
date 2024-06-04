<?php

namespace App\Models;

use App\Enums\CardGrading;
use App\Enums\CardLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardPrintState extends Model
{
    use HasFactory;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function casts(): array
    {
        return [
            'grading' => CardGrading::class,
            'language' => CardLanguage::class,
        ];
    }
}
