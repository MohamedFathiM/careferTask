<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class FrequestTripResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'trip_id' => $this->trip_id,
            'email' => $this->email,
            'frequentBookCount' => $this->email_count,
            'frequentBook' => $this->trip->pickup.'-'.$this->trip->destination,
        ];
    }
}
