<?php

use App\Http\Controllers\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsersAdminController;

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

/*
============================================================================
route di bawah ini adalah route untuk kelompok routes/aplikasi admin

format url:
/api/{type_guard}-with{sactum-guard}/{module}-with{role}/{action}
============================================================================
*/

Route::group([ 'prefix' => '/private-admin','middleware'=>['auth:sanctum','ability:privateAdmin']], function () {

    Route::group(['prefix' => '/my-account'], function () {
        Route::put('change-password', [AuthAdminController::class, 'changePassword']);
        Route::post('show-profile', [AuthAdminController::class, 'profile']);
        Route::put('update-profile', [AuthAdminController::class, 'updateProfile']);
        Route::post('account-verification-email', [AuthAdminController::class, 'AccountVerificationEmail']);
        Route::delete('logout', [AuthAdminController::class, 'logout']);
    });

    Route::group(['prefix' => '/users-admin'], function () {
        Route::group(['prefix' => '/roles-permission'], function () {
            Route::post('remove-role-admin', [RolePermissionController::class, 'removeRoleAdmin']);
            Route::post('assign-role-admin', [RolePermissionController::class, 'assignRoleAdmin']);
            Route::post('assign-permission-admin', [RolePermissionController::class, 'assignPermissionAdmin']);
            Route::post('remove-permission-admin', [RolePermissionController::class, 'removePermissionAdmin']);
            Route::put('create-rolesAdmin', [RolePermissionController::class, 'createRolePermissionAdmin']);
        });
        Route::get('show', [UsersAdminController::class, 'show']);
        Route::put('update', [UsersAdminController::class, 'update']);
        Route::delete('destroy', [UsersAdminController::class, 'destroy']);

    });

    Route::group(['prefix' => '/users-web'], function () {
        Route::group(['prefix' => '/roles-permission'], function () {
            Route::post('remove-role-web', [RolePermissionController::class, 'removeRoleWeb']);
            Route::post('assign-role-web', [RolePermissionController::class, 'assignRoleWeb']);
            Route::post('assign-permission-web', [RolePermissionController::class, 'assignPermissionWeb']);
            Route::post('remove-permission-web', [RolePermissionController::class, 'removePermissionWeb']);
            Route::put('create-rolesWeb', [RolePermissionController::class, 'createRolePermissionWeb']);
        });
        Route::get('show', [UsersController::class, 'show']);
        Route::put('update', [UsersController::class, 'update']);
        Route::delete('destroy', [UsersController::class, 'destroy']);
    });
});


/*
============================================================================
route di bawah ini adalah route untuk kelompok routes web

format url:
/api/{type_guard}-with{sactum-guard}/{module}-with{role}/{action}
============================================================================
*/


Route::group([ 'prefix' => '/private-web','middleware'=>['auth:sanctum','ability:privateWeb']], function () {

    Route::group(['prefix' => '/my-account'], function () {
        Route::put('change-password', [AuthController::class, 'changePassword']);
        Route::post('show-profile', [AuthController::class, 'profile']);
        Route::post('account-verification-email', [AuthController::class, 'AccountVerificationEmail']);
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
        Route::delete('logout', [AuthController::class, 'logout']);
    });

});
