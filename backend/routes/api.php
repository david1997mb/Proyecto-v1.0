<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[UserController::class,'store']);
Route::post('login',[UserController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::resource('users',UserController::class);
    Route::resource('clients',ClientController::class);
    Route::resource('events',EventController::class);
    Route::resource('pays',PayController::class);
    Route::resource('areas',AreaController::class);
    Route::post('logout',[UserController::class,'logout']);
});