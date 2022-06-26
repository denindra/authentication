<?php

namespace App\Services\AuthServices;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
/**
 * Class ResetPassword
 * @package App\Services
 */
class ResetPasswordService
{
    public function resetPasswordAdmin($request) {
        
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );
       
        if($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }
     
        throw ValidationException::withMessages([
            'email' =>[trans($status)]
        ]);
    }
    public function resetPassword($request) {

        $status = Password::sendResetLink(
            $request->only('email')
        );
       
        if($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }
     
        throw ValidationException::withMessages([
            'email' =>[trans($status)]
        ]);

    }
    public function resetNewPassword($request) {
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));

            });
            

            if($status == Password::PASSWORD_RESET) {
                return response([
                    'message' =>'password Reset Successfuly'
                ]);
            }

            return response([
                'message' => __($status)
            ],500);
       
    }
    public function resetNewPasswordAdmin($request) {
        
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($admin) use ($request) {
                $admin->forceFill([
                    'password' => Hash::make($request->password)
                ])->setRememberToken(Str::random(60));
     
                $admin->save();
     
                event(new PasswordReset($admin));

            });
            

            if($status == Password::PASSWORD_RESET) {
                return response([
                    'message' =>'password Reset Successfuly'
                ]);
            }

            return response([
                'message' => __($status)
            ],500);
       
    }
    
}
