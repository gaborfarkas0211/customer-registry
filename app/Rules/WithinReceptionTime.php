<?php

namespace App\Rules;

use App\Helpers\DateTimeHelper;
use App\Interfaces\TimeCollisionInterface;
use App\Models\ReceptionTime;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class WithinReceptionTime implements ValidationRule
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
        if (!$this->timeCollision->hasTimeCollision($value['start'], $value['end'])) {
            $fail('The :attribute must be in free time.');
        };
    }
}
