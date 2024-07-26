<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::post('auth/login',[AuthController::class, 'login']);
Route::post('auth/register',[AuthController::class, 'create']);
Route::get('/eventsall', [EventController::class, 'all']);
Route::post('/pays/insert',[PayController::class, 'store'] );

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/areas', AreaController::class);
    Route::get('/areasbyevent', [AreaController::class, 'areasbyevent']);
    Route::get('/areasall', [AreaController::class, 'all']);

    Route::resource('/clients', ClientController::class);
    Route::get('/clientsbyuser', [ClientController::class, 'clientsbyuser']);
    Route::get('/clientsall', [ClientController::class, 'all']);

    Route::resource('/events', EventController::class);
    Route::get('/eventsbyclients', [EventController::class, 'eventsbyclients']);

    Route::resource('/pays', PayController::class);
    Route::get('/paysbyevent', [PayController::class, 'paysbyevent']);
    Route::get('/paysall', [PayController::class, 'all']);

    Route::resource('/users', UserController::class);
    Route::get('/usersall', [UserController::class, 'all']);
    Route::get('auth/logout',[AuthController::class, 'logout']);  
});

