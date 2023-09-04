<?php

namespace App\Enums;

use App\Helpers\DateTimeHelper;
use Illuminate\Support\Carbon;

enum ReceptionTimeType: string
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

    public function validateByDate(Carbon $date): bool
    {
        return match ($this) {
            self::EveryWeek => true,
            self::EvenWeek => DateTimeHelper::isEvenWeek($date),
            self::OddWeek => DateTimeHelper::isOddWeek($date),
            default => false
        };
    }
}
