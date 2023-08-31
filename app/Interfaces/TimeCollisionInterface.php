<?php

namespace App\Interfaces;

interface TimeCollisionInterface
{
    public function hasTimeCollision(string $startTime, string $endTime): bool;
}
