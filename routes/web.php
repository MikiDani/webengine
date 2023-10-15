<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\BackendController;

Route::middleware(['web', 'auth'])->group(function() {
    Route::get('/admin/index', [BackendController::class, 'admin_index'])->name('admin_index');
    Route::get('/admin/user', [BackendController::class, 'admin_user'])->name('admin_user');
    Route::get('/admin/menus', [BackendController::class, 'admin_menus'])->name('admin_menus');
    Route::get('/admin/logout', [AuthenticationController::class, 'admin_logout'])->name('admin_logout');
});
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get ('/admin/login', [AuthenticationController::class, 'admin_login'])->name('admin_login');
    Route::post('/admin/login', [AuthenticationController::class, 'admin_login_post'])->name('admin_login_post');
    Route::get ('/admin/registration', [AuthenticationController::class, 'admin_registration'])->name('admin_registration');
    Route::post('/admin/registration', [AuthenticationController::class, 'admin_registration_post'])->name('admin_registration_post');
    
    Route::post('/admin/forgotemail', [AuthenticationController::class, 'admin_forgotemail_post'])->name('admin_forgotemail_post');
    Route::get('/admin/confirmation', [AuthenticationController::class, 'admin_confirmation'])->name('admin_confirmation');

    Route::get('/admin/newpass', [AuthenticationController::class, 'admin_newpass'])->name('admin_newpass');
    Route::post('/admin/newpass', [AuthenticationController::class, 'admin_newpass_post'])->name('admin_newpass_post');
});

Route::get('/', [FrontendController::class, 'start'])->name('start');
