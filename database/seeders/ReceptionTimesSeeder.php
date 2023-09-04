<?php

namespace Database\Seeders;

use App\Enums\ReceptionTimeDay;
use App\Enums\ReceptionTimeType;
use App\Exceptions\InvalidReceptionTypeException;
use App\Models\Event;
use App\Models\ReceptionTime;
use App\Services\ReceptionTimeEventGenerator;
use Illuminate\Database\Seeder;

class ReceptionTimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws InvalidReceptionTypeException
     */
    public function run(): void
    {
        if (ReceptionTime::count() > 0) {
            return;
        }

        $data = $this->getData();

        foreach ($data as $row) {
            $receptionTime = ReceptionTime::create($row);
            $receptionTimeEvents = (new ReceptionTimeEventGenerator($receptionTime))->getEvents();
            Event::insert($receptionTimeEvents);
        }
    }

    public function getData(): array
    {
        return [
            [
                'start_date' => '2023-09-08',
                'type' => ReceptionTimeType::OneTime,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
            ],
            [
                'start_date' => '2023-01-01',
                'type' => ReceptionTimeType::EvenWeek,
                'day' => ReceptionTimeDay::Monday,
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
            ],
            [
                'start_date' => '2023-01-01',
                'type' => ReceptionTimeType::OddWeek,
                'day' => ReceptionTimeDay::Wednesday,
                'start_time' => '12:00:00',
                'end_time' => '16:00:00',
            ],
            [
                'start_date' => '2023-01-01',
                'type' => ReceptionTimeType::EveryWeek,
                'day' => ReceptionTimeDay::Friday,
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
            ],
            [
                'start_date' => '2023-06-01',
                'end_date' => '2023-11-30',
                'type' => ReceptionTimeType::EveryWeek,
                'day' => ReceptionTimeDay::Thursday,
                'start_time' => '16:00:00',
                'end_time' => '20:00:00',
            ],
        ];
    }
}
