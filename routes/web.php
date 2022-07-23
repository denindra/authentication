<?php

use App\Http\Controllers\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersAdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return abort(500);
});


/*
============================================================================
route di bawah ini adalah route untuk kelompok routes/aplikasi yang sifatnya publik / dapat di pakai keduanya
============================================================================
*/

Route::group([ 'prefix' => '/public'], function () {

    Route::group([ 'prefix' => '/admin','middleware'=>['throttle:10,5']], function () {
        Route::group([ 'prefix' => '/auth'], function () {
            Route::post('register', [UsersAdminController::class, 'create']);
            // users Admin
            Route::post('login', [AuthAdminController::class, 'login']);
            Route::post('reset-password', [AuthAdminController::class, 'resetPassword']);
            Route::post('reset-new-password', [AuthAdminController::class, 'resetNewPassword']);
        });
    });

    Route::group([ 'prefix' => '/web'], function () {
        Route::group([ 'prefix' => '/auth','middleware'=>['throttle:10,5']], function () {
            Route::post('register', [UsersController::class, 'create']);
            // users Web
            Route::post('login', [AuthController::class, 'login']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('reset-new-password', [AuthController::class, 'resetNewPassword']);
        });
  });

});
