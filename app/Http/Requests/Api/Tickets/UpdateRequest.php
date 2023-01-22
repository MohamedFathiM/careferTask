<?php

namespace App\Http\Requests\Api\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'passengers' => 'required|array|min:1',
            'passengers.*.id' => 'required|exists:user_orders,id',
            'passengers.*.seat_id' => 'exists:seats,id',
            'passengers.*.email' => 'email',
            'passengers.*.trip_id' => 'exists:trips,id',
        ];
    }
}
