<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateTimeHelper
{
    public static function getDateTimeString(string $dateTimeString): string
    {
        return Carbon::parse($dateTimeString)->toDateTimeLocalString();
    }

    public static function setTimeAndGetDateTimeString(Carbon $date, string $time): string
    {
        return $date->copy()
            ->setTimeFromTimeString($time)
            ->toDateTimeLocalString();
    }

    public static function isEvenWeek(Carbon $date): bool
    {
        return $date->weekOfYear % 2 === 0;
    }

    public static function isOddWeek(Carbon $date): bool
    {
        return !self::isEvenWeek($date);
    }
}
