<?php

namespace App\Enums;

enum CardGrading: string
{
    case NMINT = 'NM';
    case EXCELLENT = 'EX';
    case PLAYED = 'PL';
    case POOR = 'PO';
}
