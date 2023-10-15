<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::post('/login', [AuthenticationController::class,'api_login']);
Route::post('/register', [AuthenticationController::class,'api_register']);
Route::post('/forgotemail', [AuthenticationController::class,'api_forgotemail']);
Route::get('/confirmation', [AuthenticationController::class,'api_confirmation']);

Route::middleware('auth:api')->group(function() {
    Route::get('/user',   [AuthenticationController::class,'api_user']);
    Route::patch('/modify', [AuthenticationController::class,'api_modify']);
    Route::post('/delete',  [AuthenticationController::class,'api_delete']);
    Route::post('/logout',  [AuthenticationController::class,'api_logout']);
});
