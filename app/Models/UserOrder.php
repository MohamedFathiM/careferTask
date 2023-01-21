<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    use HasFactory;

    protected $fillable  = [
        'seat_id',
        'trip_id',
        'email',
        'reservation_date',
    ];
}
