<?php

namespace Tests\Unit;

use App\Enums\ReceptionTimeDay;
use App\Enums\ReceptionTimeType;
use App\Models\ReceptionTime;
use Illuminate\Database\UniqueConstraintViolationException;
use Tests\TestCase;

class ReceptionTimeTest extends TestCase
{

    public function testOneTimeDefaultValues(): void
    {
        $customerReceptionTime = ReceptionTime::factory()->create([
            'start_date' => '2023-01-01',
            'type' => ReceptionTimeType::OneTime,
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ]);
        $this->assertDatabaseHas('reception_times', [
            'id' => $customerReceptionTime->id,
            'end_date' => '2023-01-01',
            'day' => ReceptionTimeDay::Sunday,
        ]);
        $customerReceptionTime->update(['start_date' => '2023-01-02']);
        $this->assertDatabaseHas('reception_times', [
            'id' => $customerReceptionTime->id,
            'end_date' => '2023-01-02',
            'day' => ReceptionTimeDay::Monday,
        ]);
    }

    public function testUniqueConstraintException(): void
    {
        $attributes = [
            'start_date' => '2023-01-01',
            'end_date' => '2023-06-01',
            'type' => ReceptionTimeType::EveryWeek,
            'day' => ReceptionTimeDay::Monday,
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ];
        ReceptionTime::factory()->create($attributes);
        $this->expectException(UniqueConstraintViolationException::class);
        ReceptionTime::factory()->create($attributes);
    }
}
