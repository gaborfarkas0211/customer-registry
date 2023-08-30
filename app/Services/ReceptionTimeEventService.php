<?php

namespace App\Services;

use App\Models\ReceptionTime;
use Illuminate\Support\Carbon;

class ReceptionTimeEventService
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
        $event = [
            'start' => $this->getEventDateTimeString($eventDate, $this->receptionTime->start_time),
            'end' => $this->getEventDateTimeString($eventDate, $this->receptionTime->end_time),
            'title' => 'Reception time',
            'display' => 'background',
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

    public function getEventDateTimeString(Carbon $eventStartDateTime, string $time): string
    {
        return $eventStartDateTime->setTimeFromTimeString($time)
            ->toDateTimeLocalString();
    }

    private function isValidEventDate(Carbon $eventDate): bool
    {
        return $this->receptionTime->isTypeEveryWeek() ||
            ($this->receptionTime->isTypeEvenWeek() && $this->isEvenWeek($eventDate)) ||
            ($this->receptionTime->isTypeOddWeek() && $this->isOddWeek($eventDate));
    }

    private function isEvenWeek(Carbon $currentDate): bool
    {
        return $currentDate->weekOfYear % 2 === 0;
    }

    private function isOddWeek(Carbon $currentDate): bool
    {
        return !$this->isEvenWeek($currentDate);
    }
}
