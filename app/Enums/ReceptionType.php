<?php

namespace App\Enums;

enum ReceptionType: string
{
    case OneTime = 'one_time';
    case EveryWeek = 'every_week';
    case EvenWeek = 'even_week';
    case OddWeek = 'odd_week';

    public function getWeekAdditionValue(): int
    {
        return match ($this) {
            self::EvenWeek, self::OddWeek => 2,
            self::EveryWeek => 1,
            default => 0
        };
    }
}
