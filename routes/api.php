<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'prefix' => '/auth'], function () {

    Route::group([ 'prefix' => '/public'], function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('reset-new-password', [AuthController::class, 'resetNewPassword']);
       
    });
    Route::group([ 'prefix' => '/private','middleware'=>'auth:sanctum'], function () {

        Route::post('change-password', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('profile', [AuthController::class, 'profile']);
        
        Route::post('account-verification-email', [AuthController::class, 'AccountVerificationEmail']);

    });

});

Route::group([ 'prefix' => '/user'], function () {

    Route::group([ 'prefix' => '/public'], function () {

        Route::post('register', [UsersController::class, 'create']);
       
    });

    Route::group([ 'prefix' => '/private','middleware'=>'auth:sanctum'], function () {
     
        Route::delete('destroy', [UsersController::class, 'destroy']);
        Route::get('show', [UsersController::class, 'show']);
        Route::put('update', [UsersController::class, 'update']);

    });

});


