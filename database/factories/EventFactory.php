<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\ReceptionTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_time' => $this->faker->dateTime->format('Y-m-d H:i:s'),
            'end_time' => $this->faker->dateTime->format('Y-m-d H:i:s'),
            'title' => $this->faker->name,
            'reception_time_id' => null,
        ];
    }

    public function receptionTime(): EventFactory
    {
        return $this->state(fn(array $attributes) => $attributes)->afterCreating(function (Event $event) {
            $event->receptionTime()->associate(ReceptionTime::factory()->create());
        });
    }
}
