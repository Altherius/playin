<?php

namespace App\Enums;

enum CardGame: string
{
    case MAGIC = 'magic';
    case YUGIOH = 'yugioh';
    case FAB = 'fab';
    case LORCANA = 'lorcana';

    public function name(): string
    {
        return match ($this) {
            self::MAGIC => 'Magic',
            self::YUGIOH => 'Yu-Gi-Oh',
            self::FAB => 'Flesh & Blood',
            self::LORCANA => 'Lorcana',
        };
    }
}
