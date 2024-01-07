<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FrontendController;

// FrontendPage

Route::get('/loaddata', [FrontendController::class, 'loadData']);

// Admin

Route::post('/login', [AuthenticationController::class,'api_login']);
Route::post('/register', [AuthenticationController::class,'api_register']);
Route::post('/forgotemail', [AuthenticationController::class,'api_forgotemail']);
Route::get('/confirmation', [AuthenticationController::class,'api_confirmation']);
Route::get('/apierror', [AuthenticationController::class,'api_error'])->name('api_error');

Route::middleware('auth:api')->group(function() {
	Route::get('/user',   [AuthenticationController::class,'api_user']);
	Route::patch('/modify', [AuthenticationController::class,'api_modify']);
	Route::post('/delete',  [AuthenticationController::class,'api_delete']);
	Route::post('/logout',  [AuthenticationController::class,'api_logout']);
	Route::post('/unsubscribe',  [AuthenticationController::class,'api_unsubscribe']);
});
