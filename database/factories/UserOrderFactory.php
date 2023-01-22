<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserOrder>
 */
class UserOrderFactory extends Factory
{
    public function definition()
    {
        return [
            'seat_id' => Seat::factory()->create(),
            'trip_id' => Trip::factory()->create(),
            'reservation_id' => Reservation::factory()->create(),
            'email' => $this->faker->email(),
            'reservation_date' => now(),
        ];
    }
}
