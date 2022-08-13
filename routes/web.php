<?php

use App\Http\Controllers\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersAdminController;
use \Rakutentech\LaravelRequestDocs\Controllers\LaravelRequestDocsController;

/*
============================================================================
routes untuk documenntation APIs
============================================================================
*/

Route::get(config('request-docs.url'), [LaravelRequestDocsController::class, 'index'])->name('request-docs.index')->middleware('auth');
Route::get('/login', function () { return view('login-docs'); })->name('login');
Route::get('logout', [AuthAdminController::class, 'logoutDocs']);
Route::post('login-docs', [AuthAdminController::class, 'loginDocs']);

/*
============================================================================
route di bawah ini adalah route untuk kelompok routes/aplikasi yang sifatnya publik / dapat di pakai keduanya
============================================================================
*/

Route::group([ 'prefix' => '/public'], function () {

    Route::group([ 'prefix' => '/admin','middleware'=>['throttle:authentication']], function () {
        Route::group([ 'prefix' => '/auth'], function () {
            Route::post('register', [UsersAdminController::class, 'create']);
            // users Admin
            Route::post('login', [AuthAdminController::class, 'login']);
            Route::post('reset-password', [AuthAdminController::class, 'resetPassword']);
            Route::post('reset-new-password', [AuthAdminController::class, 'resetNewPassword']);
        });
    });

    Route::group([ 'prefix' => '/web'], function () {
        Route::group([ 'prefix' => '/auth','middleware'=>['throttle:authentication']], function () {
            Route::post('register', [UsersController::class, 'create']);
            // users Web
            Route::post('login', [AuthController::class, 'login']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('reset-new-password', [AuthController::class, 'resetNewPassword']);
        });
  });

});
