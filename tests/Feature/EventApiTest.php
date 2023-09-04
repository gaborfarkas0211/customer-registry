<?php

namespace Tests\Feature;

use App\Enums\EventType;
use App\Models\Event;
use App\Models\ReceptionTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    private const EVENT_STRUCTURE = [
        'id',
        'title',
        'start_time',
        'end_time',
        'type',
    ];

    public function testGetEvents(): void
    {
        $customerEvent = Event::factory()->create();
        $receptionTime = ReceptionTime::factory()->has(Event::factory())->create();

        $response = $this->getJson('/events');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => self::EVENT_STRUCTURE,
                ],
            ]);

        $receptionTimeEvent = $receptionTime->events->first();
        $expected = ['data' => [
            [
                'id' => $customerEvent->id,
                'title' => $customerEvent->title,
                'start_time' => $customerEvent->start_time,
                'end_time' => $customerEvent->end_time,
                'type' => EventType::Normal->value,
            ],
            [
                'id' => $receptionTimeEvent->id,
                'title' => $receptionTimeEvent->title,
                'start_time' => $receptionTimeEvent->start_time,
                'end_time' => $receptionTimeEvent->end_time,
                'type' => EventType::Background->value,
            ],
        ]];
        $response->assertJson($expected);
    }

    public function testStoreValidEvent(): void
    {
        $tomorrow = Carbon::now()->addDay();
        $this->createReceptionTimeWithEventFor($tomorrow);

        $response = $this->json('POST', '/events', [
            'time_range' => [
                'start' => $tomorrow->copy()->setTimeFromTimeString('12:30:00')->toIso8601String(),
                'end' => $tomorrow->copy()->setTimeFromTimeString('13:00:00')->toIso8601String(),
            ],
            'title' => 'Test User',
        ]);
        $response->assertJsonStructure(['data' => self::EVENT_STRUCTURE])
            ->assertStatus(201);
    }

    public function testStoreEventOutOfTime(): void
    {
        $tomorrow = Carbon::now()->addDay();
        $this->createReceptionTimeWithEventFor($tomorrow);

        $response = $this->json('POST', '/events', [
            'time_range' => [
                'start' => $tomorrow->copy()->setTimeFromTimeString('16:30:00')->toIso8601String(),
                'end' => $tomorrow->copy()->setTimeFromTimeString('17:00:00')->toIso8601String(),
            ],
            'title' => 'Test User',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['time_range']]);;
    }

    public function testStoreEventOnExistingEventTime(): void
    {
        $tomorrow = Carbon::now()->addDay();
        $this->createReceptionTimeWithEventFor($tomorrow);
        Event::factory()->create([
            'start_time' => $tomorrow->copy()->setHour(12),
            'end_time' => $tomorrow->copy()->setHour(13),
        ]);

        $response = $this->json('POST', '/events', [
            'time_range' => [
                'start' => $tomorrow->copy()->setTimeFromTimeString('12:30:00')->toIso8601String(),
                'end' => $tomorrow->copy()->setTimeFromTimeString('13:00:00')->toIso8601String(),
            ],
            'title' => 'Test User',
        ]);
        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['time_range']]);
    }

    private function createReceptionTimeWithEventFor(Carbon $date): void
    {
        $receptionTime = ReceptionTime::factory()->create();
        Event::factory()->create([
            'reception_time_id' => $receptionTime->id,
            'start_time' => $date->copy()->setHour(12),
            'end_time' => $date->copy()->setHour(14),
        ]);
    }
}
