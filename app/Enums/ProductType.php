<?php

namespace App\Enums;

enum ProductType: string
{
    case CARD = 'card';
    case BOARDGAME = 'boardgame';
    case OTHER = 'other';
}
