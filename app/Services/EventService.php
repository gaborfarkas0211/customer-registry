<?php

namespace App\Services;

use App\Interfaces\TimeCollisionInterface;
use App\Models\Event;

class EventService implements TimeCollisionInterface
{
    public function hasTimeCollision(string $startTime, string $endTime): bool
    {
        return $this->isWithinReceptionTime($startTime, $endTime);
    }

    public function isWithinReceptionTime(string $startTime, string $endTime): bool
    {
        return Event::query()
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->whereHas('receptionTime')
            ->exists();
    }
}
