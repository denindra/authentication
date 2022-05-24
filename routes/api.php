<?php

use App\Http\Controllers\AuthAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;
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

/*
============================================================================
route di bawah ini adalah route untuk kelompok routes/aplikasi yang sifatnya publik / dapat di pakai keduanya
============================================================================
*/

Route::group([ 'prefix' => '/public'], function () {

        Route::group([ 'prefix' => '/admin'], function () {

            Route::group([ 'prefix' => '/auth'], function () {

                Route::post('register', [UsersController::class, 'create']);
                // users Admin
                Route::post('login', [AuthAdminController::class, 'login']); //v
                Route::post('reset-password', [AuthAdminController::class, 'resetPassword']);
                Route::post('reset-new-password', [AuthAdminController::class, 'resetNewPassword']);

            });
             
         
        });

        Route::group([ 'prefix' => '/web'], function () {

            Route::group([ 'prefix' => '/auth'], function () {

                Route::post('register', [UsersController::class, 'create']);
                // users Web
                Route::post('login', [AuthController::class, 'login']);  //v
                Route::post('reset-password', [AuthController::class, 'resetPassword']);
                Route::post('reset-new-password', [AuthController::class, 'resetNewPassword']);
            });
    
      });

});

/*
============================================================================
route di bawah ini adalah route untuk kelompok routes/aplikasi admin

format url: 
/api/{type_guard}-with{sactum-guard}/{module}-with{role}/{action}
============================================================================
*/

Route::group([ 'prefix' => '/private-admin','middleware'=>['auth:sanctum','ability:privateAdmin']], function () {

    Route::group(['prefix' => '/my-account','middleware' => 'role:manage-own-account-admin'], function () {

        Route::post('change-password', [AuthController::class, 'login']);
        Route::post('show-profile', [AuthController::class, 'profile']);
        Route::post('account-verification-email', [AuthController::class, 'AccountVerificationEmail']);
    
    });

    Route::group(['prefix' => '/users-admin'], function () {
        
        Route::group(['prefix' => '/roles-permission'], function () {
            Route::post('remove-role-admin', [RolePermissionController::class, 'removeRoleAdmin']);
            Route::post('assign-role-admin', [RolePermissionController::class, 'assignRoleAdmin']);
            Route::post('assign-permission-admin', [RolePermissionController::class, 'assignPermissionAdmin']);
            Route::post('remove-permission-admin', [RolePermissionController::class, 'removePermissionAdmin']);
            Route::put('create-rolesAdmin', [RolePermissionController::class, 'createRolePermissionAdmin']);
          
        });

        Route::get('show', [UsersController::class, 'show']);

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

    });


    Route::post('logout', [AuthController::class, 'logout']);
    
});


/*
============================================================================
route di bawah ini adalah route untuk kelompok routes web

format url: 
/api/{type_guard}-with{sactum-guard}/{module}-with{role}/{action}
============================================================================
*/


Route::group([ 'prefix' => '/private-web','middleware'=>['auth:sanctum','ability:privateWeb']], function () {

    Route::group(['prefix' => '/my-account','middleware' => 'role:manage-own-account-web'], function () {

        Route::post('change-password', [AuthController::class, 'login']);
        Route::post('show-profile', [AuthController::class, 'profile']);
        Route::post('account-verification-email', [AuthController::class, 'AccountVerificationEmail']);
    
    });

    Route::post('logout', [AuthController::class, 'logout']);

});


















// Route::group([ 'prefix' => '/auth'], function () {

//     Route::group([ 'prefix' => '/public'], function () {

  
//         Route::post('login-admin', [AuthAdminController::class, 'login']);
//         Route::post('reset-password-admin', [AuthAdminController::class, 'resetPassword']);
//         Route::post('reset-new-password-admin', [AuthAdminController::class, 'resetNewPassword']);

//         Route::post('login-web', [AuthController::class, 'login']);
//         Route::post('reset-password-web', [AuthController::class, 'resetPassword']);
//         Route::post('reset-new-password-web', [AuthController::class, 'resetNewPassword']);
      
       
//     });
//     Route::group([ 'prefix' => '/private-admin','middleware'=>'auth:sanctum','ability:privateAdmin'], function () {

//         Route::group([ 'middleware' => 'role:manage-own-account-admin'], function () {

//             Route::post('change-password', [AuthController::class, 'login']);
//             Route::post('show-profile', [AuthController::class, 'profile']);
//             Route::post('account-verification-email', [AuthController::class, 'AccountVerificationEmail']);
          

//         });

//         Route::post('logout', [AuthController::class, 'logout']);

//     });

//     Route::group([ 'prefix' => '/private-web','middleware'=>'auth:sanctum','ability:privateWeb'], function () {

//         Route::group([ 'middleware' => 'role:manage-own-account-web'], function () {
//             Route::post('change-password', [AuthController::class, 'login']);
//             Route::post('account-verification-email', [AuthController::class, 'AccountVerificationEmail']);
//             Route::post('show-profile', [AuthController::class, 'profile']);
//         });

       
//         Route::post('logout', [AuthController::class, 'logout']);
       
//     });

// });















// Route::group([ 'prefix' => '/user'], function () {

//     Route::group([ 'prefix' => '/public'], function () {
//         Route::post('register', [UsersController::class, 'create']);
//     });

//     Route::group([ 'prefix' => '/private-admin','middleware'=>['auth:sanctum','ability:privateAdmin']], function () {
     
//         Route::delete('destroy', [UsersController::class, 'destroy']);
//         Route::middleware('role:web-user')->get('show', [UsersController::class, 'show']);
//         Route::put('update', [UsersController::class, 'update']);

//     });

// });


