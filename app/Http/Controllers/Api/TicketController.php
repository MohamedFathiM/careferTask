<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketRequest;
use App\Http\Resources\Api\OrderCollection;
use App\Models\Bus;
use App\Models\Reservation;
use Illuminate\Support\Facades\Cache;

class TicketController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('userOrders')->paginate();

        return successResponse(OrderCollection::collection($reservations), $reservations);
    }

    public function store(TicketRequest $request)
    {
        $data = $request->validated();
        $bus = Bus::find($data['bus_id']);
        $lock = Cache::lock('bus'.$bus->id.'_lock', 120);

        try {
            if ($lock->get()) {
                if ($bus->userOrders()->count() >= $bus->seats_number) {
                    return failedResponse('Bus Exceed Capacity', 422);
                }

                if (count($data['passengers']) >= 5) {
                    $discount = ['discount' => 20];
                }

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

        return successResponse(data: $reservation, message: 'Done');
    }

    public function show($id)
    {
        $reservation = Reservation::with('userOrders')->findOrFail($id);

        return successResponse(OrderCollection::make($reservation));
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
