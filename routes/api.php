<?php

use App\Http\Controllers\AuthControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthControler::class, 'register']);
Route::post('/login', [AuthControler::class, 'login']);