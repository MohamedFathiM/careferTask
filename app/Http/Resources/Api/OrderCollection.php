<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'bus' => [
                'id' => $this->bus?->id,
                'name' => $this->bus?->name,
            ],
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'userOrders' => OrderResource::collection($this->userOrders),
        ];
    }
}
