<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\BackendController;

// BACKEND

Route::post('/changelang', [BackendController::class, 'changelang'])->name('changelang');

Route::middleware(['web', 'auth'])->group(function() {
	Route::get('/admin/index', [BackendController::class, 'admin_index'])->name('admin_index');
	Route::get('/admin/menus/{menulistid?}', [BackendController::class, 'admin_menus'])->name('admin_menus');
	Route::post('/admin/menus/save', [BackendController::class, 'menus_save'])->name('menu_save');

	Route::get('/admin/user', [BackendController::class, 'admin_user'])->name('admin_user');
	Route::post('/admin/modify', [AuthenticationController::class, 'admin_modify_post'])->name('admin_modify_post');
	Route::get('/admin/logout', [AuthenticationController::class, 'admin_logout'])->name('admin_logout');
	Route::post('/admin/unsubscribe',  [AuthenticationController::class,'admin_unsubscribe'])->name('admin_unsubscribe');
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

// FRONTEND

Route::get('/', [FrontendController::class, 'start'])->name('start');
