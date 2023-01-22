<?php

use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('frequent_booked', [TicketController::class, 'frequentBooked']);
Route::apiResource('orders', TicketController::class);
