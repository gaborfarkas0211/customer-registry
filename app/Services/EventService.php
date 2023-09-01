<?php

namespace App\Services;

use App\Interfaces\TimeCollisionInterface;
use App\Models\Event;

class EventService implements TimeCollisionInterface
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
            ->where(
                fn($query) => $query->orWhere(fn($query) => $query->timeRange($startTime, $endTime, 'start_time'))
                    ->orWhere(fn($query) => $query->timeRange($startTime, $endTime, 'end_time'))
                    ->orWhere(fn($query) => $query->where('start_time', '>', $startTime)
                        ->where('end_time', '<', $endTime))
                    ->orWhere(fn($query) => $query->where('start_time', '<', $startTime)
                        ->where('end_time', '>', $endTime))
            )
            ->exists();
    }
}
