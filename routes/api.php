<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\saveImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/messages/send', [MessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages']);
    Route::post('/upload-image', [saveImageController::class, 'upload']);
});