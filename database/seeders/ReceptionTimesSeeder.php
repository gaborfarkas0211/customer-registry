<?php

namespace Database\Seeders;

use App\Enums\ReceptionDay;
use App\Enums\ReceptionType;
use App\Models\Event;
use App\Models\ReceptionTime;
use App\Services\ReceptionTimeEventGenerator;
use Illuminate\Database\Seeder;

class ReceptionTimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                'type' => ReceptionType::OneTime,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
            ],
            [
                'start_date' => '2023-01-01',
                'type' => ReceptionType::EvenWeek,
                'day' => ReceptionDay::Monday,
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
            ],
            [
                'start_date' => '2023-01-01',
                'type' => ReceptionType::OddWeek,
                'day' => ReceptionDay::Wednesday,
                'start_time' => '12:00:00',
                'end_time' => '16:00:00',
            ],
            [
                'start_date' => '2023-01-01',
                'type' => ReceptionType::EveryWeek,
                'day' => ReceptionDay::Friday,
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
            ],
            [
                'start_date' => '2023-06-01',
                'end_date' => '2023-11-30',
                'type' => ReceptionType::EveryWeek,
                'day' => ReceptionDay::Thursday,
                'start_time' => '16:00:00',
                'end_time' => '20:00:00',
            ],
        ];
    }
}
