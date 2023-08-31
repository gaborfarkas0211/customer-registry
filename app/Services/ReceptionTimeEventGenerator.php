<?php

namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Models\ReceptionTime;
use Illuminate\Support\Carbon;

class ReceptionTimeEventGenerator
{
    private array $events = [];

    public function __construct(private readonly ReceptionTime $receptionTime)
    {
        $this->generate();
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    private function generate(): void
    {
        $eventDate = $this->getFirstEventDate();
        if ($this->receptionTime->isOneTime()) {
            $this->addEvent($this->receptionTime->start_date);
            return;
        }
        while ($eventDate->lte($this->receptionTime->event_end_date)) {
            $this->addEvent($eventDate);
            $eventDate->addWeeks($this->receptionTime->type->getWeekAdditionValue());
        }
    }

    private function addEvent(Carbon $eventDate): void
    {
        $dateTimeString = fn(Carbon $date, string $startTime) => DateTimeHelper::setTimeAndGetDateTimeString($date, $startTime);
        $event = [
            'reception_time_id' => $this->receptionTime->id,
            'start_time' => $dateTimeString($eventDate, $this->receptionTime->start_time),
            'end_time' => $dateTimeString($eventDate, $this->receptionTime->end_time),
        ];
        $this->events[] = $event;
    }

    private function getFirstEventDate(): Carbon
    {
        $startDate = $this->receptionTime->start_date;
        $eventDate = $startDate->setDaysFromStartOfWeek($this->receptionTime->day->value);
        if ($this->isValidEventDate($eventDate)) {
            return $eventDate;
        }

        $eventDate->addWeek();
        return $eventDate;
    }

    private function isValidEventDate(Carbon $eventDate): bool
    {
        return $this->receptionTime->isTypeEveryWeek() ||
            ($this->receptionTime->isTypeEvenWeek() && DateTimeHelper::isEvenWeek($eventDate)) ||
            ($this->receptionTime->isTypeOddWeek() && DateTimeHelper::isOddWeek($eventDate));
    }
}
