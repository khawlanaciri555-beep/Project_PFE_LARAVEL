<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'user'])->middleware('auth:sanctum');

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::apiResource('favorites', \App\Http\Controllers\Api\FavoriteController::class);
    Route::apiResource('plannings', \App\Http\Controllers\Api\PlanningController::class);
    Route::apiResource('emergencies', \App\Http\Controllers\Api\EmergencyController::class);
    Route::post('/ratings', [\App\Http\Controllers\Api\RatingController::class, 'store']);
    Route::post('/comments', [\App\Http\Controllers\Api\CommentController::class, 'store']);
});

Route::get('/places/{placeId}/comments', [\App\Http\Controllers\Api\CommentController::class, 'index']);
Route::post('/upload', [\App\Http\Controllers\Api\UploadController::class, 'upload']);

Route::apiResource('hotels', \App\Http\Controllers\Api\HotelController::class);
Route::apiResource('cooperatives', \App\Http\Controllers\Api\CooperativeController::class);
Route::apiResource('transports', \App\Http\Controllers\Api\TransportController::class);
Route::apiResource('places', \App\Http\Controllers\Api\PlaceController::class);
Route::apiResource('services', \App\Http\Controllers\Api\ServiceController::class);
Route::apiResource('bookings', \App\Http\Controllers\Api\BookingController::class);
Route::apiResource('bookings', \App\Http\Controllers\Api\BookingController::class);
