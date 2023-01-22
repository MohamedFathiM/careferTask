<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Seat;
use App\Models\Trip;
use Tests\TestCase;

class TicketTest extends TestCase
{
    public function test_store_ticket()
    {
        $bus = Bus::factory()->create([
            'name' => 'Bus One',
            'seats_number' => 20,
        ]);

        $seat = Seat::factory()->create();
        $trip = Trip::factory()->create();

        $response = $this->postJson(route('orders.store'), [
            'bus_id' => $bus->id,
            'passengers' => [
                [
                    'seat_id' => $seat->id,
                    'email' => 'ahmed@yahoo.com',
                    'trip_id' => $trip->id,
                ],
            ],

        ]);

        $response->assertStatus(200)->assertSeeText('Done');
    }

    public function test_cannot_store_when_exceed_capacity()
    {
        $bus = Bus::factory()->create([
            'name' => 'Bus One',
            'seats_number' => 2,
        ]);

        $this->postJson(route('orders.store'), [
            'bus_id' => $bus->id,
            'passengers' => [
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
            ],

        ]);

        $response = $this->postJson(route('orders.store'), [
            'bus_id' => $bus->id,
            'passengers' => [
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
            ],

        ]);

        $response->assertStatus(422)->assertSeeText('Bus Exceed Capacity');
    }

    public function test_if_passengers_larger_than_five_make_discount()
    {
        $bus = Bus::factory()->create([
            'name' => 'Bus One',
            'seats_number' => 2,
        ]);

        $response = $this->postJson(route('orders.store'), [
            'bus_id' => $bus->id,
            'passengers' => [
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed1@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed2@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed3@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed4@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
                [
                    'seat_id' => Seat::factory()->create()->id,
                    'email' => 'ahmed5@yahoo.com',
                    'trip_id' => Trip::factory()->create()->id,
                ],
            ],

        ]);

        $response->assertStatus(200)->assertJsonPath('data.discount', 20);
    }
}
