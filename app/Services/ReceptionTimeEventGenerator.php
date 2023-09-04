<?php

namespace App\Services;

use App\Exceptions\InvalidReceptionTypeException;
use App\Models\ReceptionTime;
use Illuminate\Support\Carbon;

class ReceptionTimeEventGenerator
{
    private array $events = [];

    /**
     * @throws InvalidReceptionTypeException
     */
    public function __construct(private readonly ReceptionTime $receptionTime)
    {
        $this->generate();
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @throws InvalidReceptionTypeException
     */
    private function generate(): void
    {
        if ($this->receptionTime->isOneTime()) {
            $this->addEvent($this->receptionTime->start_date);
            return;
        }
        $eventDate = $this->getFirstEventDate();
        while ($eventDate->lt($this->receptionTime->event_end_date)) {
            $this->addEvent($eventDate);
            $eventDate->addWeeks($this->receptionTime->type->getWeekAdditionValue());
        }
    }

    private function addEvent(Carbon $eventDate): void
    {
        $this->events[] = (new ReceptionEvent($this->receptionTime, $eventDate))->toArray();
    }

    /**
     * @throws InvalidReceptionTypeException
     */
    private function getFirstEventDate(): Carbon
    {
        $validationCount = 0;
        $startDate = $this->receptionTime->start_date;
        $eventDate = $startDate->setDaysFromStartOfWeek($this->receptionTime->day->value);
        while (!$this->isValidEventDate($eventDate)) {
            $eventDate->addWeek();

            $validationCount++;
            if ($validationCount >= config('reception_times.max_validation_number')) {
                throw new InvalidReceptionTypeException();
            }
        }

        return $eventDate;
    }

    private function isValidEventDate(Carbon $eventDate): bool
    {
        return $this->receptionTime->type->validateByDate($eventDate);
    }
}
