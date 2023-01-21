<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function rules()
    {
        return [
            'bus_id' => 'required|exists:buses,id',
            'passengers' => 'required|array|min:1',
            'passengers.*.seat_id' => 'exists:seats,id',
            'passengers.*.email' => 'email',
            'passengers.*.trip_id' => 'exists:trips,id',
        ];
    }
}
