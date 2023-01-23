<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\UserOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    // use RefreshDatabase;

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

    public function test_if_order_soft_deleted()
    {
        $reservation = Reservation::factory()->create();
        $userOrder = UserOrder::factory()->create([
            'reservation_id' => $reservation->id,
        ]);

        $response = $this->deleteJson(route('orders.destroy', $reservation));

        $response->assertStatus(200)->assertSee('Deleted Successfully ');
        $this->assertSoftDeleted($reservation);
        $this->assertSoftDeleted($userOrder);
    }

    public function test_update_ticket()
    {
        $reservation = Reservation::factory()->create();
        $userOrder = UserOrder::factory()->create([
            'reservation_id' => $reservation->id,
            'email' => 'ahmed@yahoo.com',
        ]);

        $response = $this->putJson(route('orders.update', $reservation), [
            'passengers' => [
                [
                    'id' => $userOrder->id,
                    'email' => 'abutaleb@yahoo.com',
                ],
            ],

        ]);

        $response->assertStatus(200)->assertJsonPath(
            'data.userOrders.0.email',
            'abutaleb@yahoo.com'
        )
            ->assertSeeText('Updated Successfully');
    }
}
