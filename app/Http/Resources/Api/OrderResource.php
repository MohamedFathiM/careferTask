<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trip' => [
                'id' => $this->trip?->id,
                'pickup' => $this->trip?->pickup,
                'destination' => $this->trip?->destination
            ],
            'email' => $this->email,
            'date' => $this->reservation_date->format('Y-m-d'),
            'created_at' => $this->created_at
        ];
    }
}
