<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Event routes
Route::apiResource('events', EventController::class);

// Attendee routes
Route::post('attendees', [AttendeeController::class, 'store']);

// Booking routes
Route::post('bookings', [BookingController::class, 'store']);

// For authentication, we would add middleware('auth:sanctum') to these routes
// Example: Route::middleware('auth:sanctum')->group(function () { ... });