<?php

namespace Database\Factories;

use App\Enums\ReceptionTimeDay;
use App\Enums\ReceptionTimeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReceptionTime>
 */
class ReceptionTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'type' => $this->faker->randomElement(ReceptionTimeType::cases()),
            'day' => $this->faker->randomElement(ReceptionTimeDay::cases()),
            'start_time' => $this->faker->time,
            'end_time' => $this->faker->time,
        ];
    }
}
