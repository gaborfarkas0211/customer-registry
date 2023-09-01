<?php

namespace App\Rules;

use App\Interfaces\TimeCollisionInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithinTimeRange implements ValidationRule
{
    public function __construct(private readonly TimeCollisionInterface $timeCollision)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->timeCollision->hasTimeCollision($value['start'], $value['end'])) {
            $fail('The :attribute must be in free time.');
        }
    }
}
