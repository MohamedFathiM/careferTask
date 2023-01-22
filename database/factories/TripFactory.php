<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['short', 'long']);
        return [
            'type' => $type,
            'pickup' => 'Cairo',
            'destination' => $this->faker->randomElement(['Aswan', 'Alexandria']),
            'distance' => $type == 'long' ? 150  : 90,
        ];
    }
}
