<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\AuthControlerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//login user
Route::post('/login', [AuthControlerUser::class, 'login']);

//registro usuario
Route::post('/register', [AuthControler::class, 'register']);
//Route::post('/login', [AuthControler::class, 'login']);

//rol vigilante
Route::middleware(['auth:sanctum', 'role:guarda'])->group(function () {
    Route::get('/me' , function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthControler::class, 'logout']);
});
