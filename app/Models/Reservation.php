<?php

namespace App\Models;

use App\Traits\HasTimestampTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, HasTimestampTrait, SoftDeletes;

    protected $fillable  = [
        'bus_id',
        'total_amount',
        'discount'
    ];
    #region relationships
    public function passenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function userOrders()
    {
        return $this->hasMany(UserOrder::class);
    }
    #endregion relationships
}
