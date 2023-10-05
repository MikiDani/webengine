<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\BackendController;

Route::middleware(['auth'])->group(function() {
    Route::get('/admin/index', [BackendController::class, 'admin_index'])->name('admin_index');
    Route::get('/admin/index/two', [BackendController::class, 'admin_index_two'])->name('admin_index_two');
    Route::get('/admin/logout', [AuthenticationController::class, 'admin_logout'])->name('admin_logout');
});
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get ('/admin/login', [AuthenticationController::class, 'admin_login'])->name('admin_login');
    Route::post('/admin/login', [AuthenticationController::class, 'admin_login_post'])->name('admin_login_post');
});

Route::get('/', [FrontendController::class, 'start'])->name('start');
Route::get('/test', [FrontendController::class, 'test'])->name('test');
