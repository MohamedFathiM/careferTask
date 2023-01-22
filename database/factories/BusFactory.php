<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BusFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->streetName(),
            'seats_number' => $this->faker->numberBetween(20, 100),
        ];
    }
}
