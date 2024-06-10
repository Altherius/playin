<?php

namespace App\Enums;

enum PaymentMode: string
{
    case VOUCHER = 'voucher';
    case CASH = 'cash';
    case PAYPAL = 'paypal';
}
