<?php

namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Models\ReceptionTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Carbon;

class ReceptionEvent implements Arrayable
{
    private readonly Carbon $eventDate;

    public function __construct(private readonly ReceptionTime $receptionTime, Carbon $eventDate)
    {
        $this->eventDate = $eventDate->copy();
    }

    public function toArray(): array
    {
        $dateTimeString = static fn(Carbon $date, string $startTime): string => DateTimeHelper::setTimeAndGetDateTimeString($date, $startTime);
        return [
            'reception_time_id' => $this->receptionTime->id,
            'start_time' => $dateTimeString($this->eventDate, $this->receptionTime->start_time),
            'end_time' => $dateTimeString($this->eventDate, $this->receptionTime->end_time),
        ];
    }
}
