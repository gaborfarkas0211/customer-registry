<?php

namespace App\Repositories;

use App\Interfaces\TimeCollisionInterface;
use App\Models\Event;

class EventRepository implements TimeCollisionInterface
{
    public function hasTimeCollision(string $startTime, string $endTime): bool
    {
        return $this->outOfReceptionTime($startTime, $endTime) || $this->hasEventBetween($startTime, $endTime);
    }

    public function outOfReceptionTime(string $startTime, string $endTime): bool
    {
        return Event::query()
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->whereHas('receptionTime')
            ->get()
            ->isEmpty();
    }

    public function hasEventBetween(string $startTime, string $endTime): bool
    {
        return Event::query()
            ->whereDoesntHave('receptionTime')
            ->where(fn($query) => $query->where(fn($query) => $query->startTimeRange($startTime, $endTime))
                ->orWhere(fn($query) => $query->endTimeRange($startTime, $endTime))
                ->orWhere(fn($query) => $query->where('start_time', '<', $startTime)
                    ->where('end_time', '>', $endTime)))
            ->exists();
    }
}
