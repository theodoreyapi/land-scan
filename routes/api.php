<?php

use App\Http\Controllers\Apis\ApiAgentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('loginAgent', [ApiAgentsController::class, 'postLoginAgent']);
Route::get('event/{id}', [ApiAgentsController::class, 'getEvent']);
Route::get('eventFive/{id}', [ApiAgentsController::class, 'getEventFive']);
Route::get('logout/{id}', [ApiAgentsController::class, 'logoutAgent']);
