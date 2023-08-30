<?php

namespace App\Factories;

use App\Models\ReceptionTime;
use App\Services\ReceptionTimeEventService;

class ReceptionTimeEventFactory
{
    private array $events = [];

    public function __construct()
    {
        $this->setEvents();
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    private function setEvents(): void
    {
        ReceptionTime::all()->each(function (ReceptionTime $receptionTime) {
            $receptionTimeEvents = (new ReceptionTimeEventService($receptionTime))->getEvents();
            $this->events = [...$this->events, ...$receptionTimeEvents];
        });
    }
}
