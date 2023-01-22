<?php

namespace App\Models;

use App\Traits\HasTimestampTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOrder extends Model
{
    use HasFactory, HasTimestampTrait, SoftDeletes;

    protected $fillable  = [
        'seat_id',
        'trip_id',
        'email',
        'reservation_date',
    ];

    public $dates = ['reservation_date'];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
