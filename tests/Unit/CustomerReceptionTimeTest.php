<?php

use App\Enums\ReceptionType;
use App\Models\CustomerReceptionTime;
use Illuminate\Database\UniqueConstraintViolationException;
use Tests\TestCase;

class CustomerReceptionTimeTest extends TestCase
{

    public function testOneTimeDefaultValues(): void
    {
        $customerReceptionTime = CustomerReceptionTime::factory()->create([
            'start_date' => '2023-01-01',
            'type' => ReceptionType::OneTime,
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ]);
        $this->assertDatabaseHas('customer_reception_times', [
            'id' => $customerReceptionTime->id,
            'end_date' => '2023-01-01',
            'day' => \App\Enums\ReceptionDay::Sunday,
        ]);
        $customerReceptionTime->update(['start_date' => '2023-01-02']);
        $this->assertDatabaseHas('customer_reception_times', [
            'id' => $customerReceptionTime->id,
            'end_date' => '2023-01-02',
            'day' => \App\Enums\ReceptionDay::Monday,
        ]);
    }

    public function testUniqueConstraintException(): void
    {
        $attributes = [
            'start_date' => '2023-01-01',
            'end_date' => '2023-06-01',
            'type' => ReceptionType::EveryWeek,
            'day' => \App\Enums\ReceptionDay::Monday,
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ];
        CustomerReceptionTime::factory()->create($attributes);
        $this->expectException(UniqueConstraintViolationException::class);
        CustomerReceptionTime::factory()->create($attributes);

    }
}
