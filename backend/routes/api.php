<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('users',UserController::class);
Route::resource('clients',ClientController::class);
Route::resource('events',EventController::class);
Route::resource('pays',PayController::class);