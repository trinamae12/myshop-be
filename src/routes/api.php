<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('login', [AuthenticationController::class, 'store']);
Route::delete('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');
Route::post('register', [UserController::class, 'store']);
Route::resource('users', UserController::class)->middleware('auth:api');
