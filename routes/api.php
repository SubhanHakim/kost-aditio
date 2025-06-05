<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PembayaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->post('/booking', [BookingController::class, 'store']);
// Route::post('/xendit/webhook', [PembayaranController::class, 'webhook']);

Route::middleware('auth:sanctum')->post('/booking', [BookingController::class, 'store']);
Route::post('/midtrans/webhook', [PembayaranController::class, 'webhook']);


