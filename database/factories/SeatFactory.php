<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'bus_id' => Bus::factory()->create(),
            'trip_id' => Trip::factory()->create(),
            'seat_id' => 'A' . $this->faker->numberBetween(1, 20)
        ];
    }
}
