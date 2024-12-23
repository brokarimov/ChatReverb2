<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MessageController::class, 'index']);
Route::get('/send', [MessageController::class, 'create']);
Route::post('/store', [MessageController::class, 'store']);
Route::get('/read/{message}', [MessageController::class, 'read']);



