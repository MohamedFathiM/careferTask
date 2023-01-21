<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketRequest;
use App\Models\Bus;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TicketController extends Controller
{
    public function index()
    {
        //
    }

    public function store(TicketRequest $request)
    {
        $data = $request->validated();
        $bus  = Bus::find($data['bus_id']);
        $lock = Cache::lock('bus' . $bus->id . '_lock', 120);

        try {
            if ($lock->get()) {
                if ($bus->seats_number <= $bus->reservations()->count()) {
                    return failedResponse('Bus Exceed Capacity');
                }

                if (count($data['passengers']) >= 5) $discount = ['discount' => 20];

                $reservation = Reservation::create([
                    'bus_id' => $data['bus_id'],
                    'total_amount' => count($data['passengers']) * 20,
                ] + ($discount ?? []));

                foreach ($data['passengers'] as $passenger) {
                    $reservation->userOrders()->create([
                        'seat_id' => $passenger['seat_id'],
                        'trip_id' => $passenger['trip_id'],
                        'email' => $passenger['email'],
                        'reservation_date' => now(),
                    ]);
                }
            }
        } finally {
            $lock->release();
        }

        return successResponse('Done');
    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
