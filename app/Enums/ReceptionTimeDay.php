<?php

namespace App\Enums;

use Carbon\Carbon;

enum ReceptionTimeDay: int
{
    case Monday = 1;
    case Tuesday = 2;
    case Wednesday = 3;
    case Thursday = 4;
    case Friday = 5;
    case Saturday = 6;
    case Sunday = 7;

    public static function getByDate(string|Carbon $date): self|null
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }
        $dayNumber = $date->dayOfWeekIso;

        return self::tryFrom($dayNumber);
    }
}
