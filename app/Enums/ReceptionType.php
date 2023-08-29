<?php

namespace App\Enums;

enum ReceptionType: string
{
    case OneTime = 'one_time';
    case EveryWeek = 'every_week';
    case EvenWeek = 'even_week';
    case OddWeek = 'odd_week';
}
