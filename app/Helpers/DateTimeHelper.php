<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateTimeHelper
{
    public static function getDateTimeString(string $dateTimeString): string
    {
        $dateTime = Carbon::parse($dateTimeString);

        return $dateTime->toDateTimeLocalString();
    }

    public static function setTimeAndGetDateTimeString(Carbon $date, string $time): string
    {
        return $date->setTimeFromTimeString($time)
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
