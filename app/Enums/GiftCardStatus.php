<?php

namespace App\Enums;

enum GiftCardStatus: string
{
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case USED = 'used';
}
