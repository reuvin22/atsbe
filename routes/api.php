<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('alumni', AlumniController::class);
Route::apiResource('register', AlumniController::class);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group( function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('alumni-list', AlumniController::class);
    Route::apiResource('users', AlumniController::class);
});
