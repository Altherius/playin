<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case AWAITING_PAYMENT = 'awaiting_payment';
    case PROCESSING_PAYMENT = 'processing_payment';
    case PAYMENT_ACCEPTED = 'payment_accepted';
    case PAYMENT_REJECTED = 'payment_rejected';
}
