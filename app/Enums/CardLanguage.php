<?php

namespace App\Enums;

enum CardLanguage: string
{
    case FRENCH = 'FR';
    case ENGLISH = 'EN';
    case SPANISH = 'ES';
    case ITALIAN = 'IT';
    case GERMAN = 'DE';
    case PORTUGUESE = 'PT';
    case RUSSIAN = 'RU';
    case JAPANESE = 'JA';
    case KOREAN = 'KO';
    case CHINESE_SIMPLIFIED = 'ZH-CN';
    case CHINESE_TRADITIONAL = 'ZH-HANT';
}
