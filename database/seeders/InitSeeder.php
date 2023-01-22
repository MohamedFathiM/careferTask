<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    public function run()
    {
        $busOne = Bus::create([
            'name' => 'Bus 01',
            'seats_number' => 20,
        ]);

        $busTwo = Bus::create([
            'name' => 'Bus 02',
            'seats_number' => 20,
        ]);

        $shortTrip = Trip::create([
            'type' => 'short',
            'pickup' => 'Cairo',
            'destination' => 'Alexandria',
            'distance' => 90,
        ]);

        $longTrip = Trip::create([
            'type' => 'long',
            'pickup' => 'Cairo',
            'destination' => 'Aswan',
            'distance' => 150,
        ]);

        for ($seat = 1; $seat <= 20; $seat++) {
            $lineOneSeats[] = [
                'trip_id' => $shortTrip->id,
                'seat_id' => 'A'.$seat,
            ];

            $lineTwoSeats[] = [
                'trip_id' => $longTrip->id,
                'seat_id' => 'B'.$seat,
            ];
        }

        $busOne->seats()->createMany($lineOneSeats);
        $busTwo->seats()->createMany($lineTwoSeats);
    }
}
