<?php

namespace App\Enums;

enum PaymentMode: string
{
    case STORE_CREDIT = 'store_credit';
    case CASH = 'cash';
    case PAYPAL = 'paypal';
}
