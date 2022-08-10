<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginAdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthServices\LoginByEmailService;
use App\Services\AuthServices\ResetPasswordService;
use App\Http\Requests\AuthRequest\ResetPasswordRequest;
use App\Http\Requests\AuthRequest\ResetNewPasswordRequest;
use App\Http\Requests\AuthRequest\UpdateProfileAdminRequest;
use App\Http\Requests\UsersRequest\ChangePasswordRequest;
use App\Services\AuthServices\ChangePasswordService;
use App\Services\AuthServices\UpdateProfileService;

class AuthAdminController extends BaseController
{
    private $LoginByEmailService;
    private $ResetPasswordService;
    private $ChangePasswordService;
    private $UpdateProfileService;

    public function __construct(
        LoginByEmailService $LoginByEmailService,
        ResetPasswordService $ResetPasswordService,
        ChangePasswordService $ChangePasswordService,
        UpdateProfileService  $UpdateProfileService
    )
    {
            $this->LoginByEmailService        = $LoginByEmailService;
            $this->ResetPasswordService       = $ResetPasswordService;
            $this->ChangePasswordService      = $ChangePasswordService;
            $this->UpdateProfileService       = $UpdateProfileService;
    }

    public function login(LoginAdminRequest $request)
    {

        $loginUser =  $this->LoginByEmailService->userNamePasswordAdmin($request);

        if($loginUser['status']) {
           return  $this->handleResponse($loginUser['response'],'login success');
        }
        else {
         return   $this->handleError($loginUser['response'],'login error',422);

        }
    }
    public function logout(Request $request)
    {
        $checkToGetData = Auth::user($request->header('Authorization'));

        if($checkToGetData)
        {
            $deleteAccount  =   Auth::user($request->header('Authorization'))->tokens()->delete();

            return  $this->handleResponse('Response : '.$deleteAccount,'logout success');
        }
        else
        {
            return  $this->handleError($checkToGetData,'Unauthorization',422);
        }

    }
    public function resetPassword(ResetPasswordRequest $request ) {

       return  $this->ResetPasswordService->resetPasswordAdmin($request);

    }
    public function resetNewPassword(ResetNewPasswordRequest $request) {

        return  $this->ResetPasswordService->resetNewPasswordAdmin($request);

    }
    public function changePassword(ChangePasswordRequest $request) {

       $checkToGetData = Auth::user($request->header('Authorization'));

       if($checkToGetData) {

            $request->request->add(['id' => $checkToGetData->id]);
            $resetPass =   $this->ChangePasswordService->updatePasswordAdmin($request);

            if($resetPass['status']) {
               return  $this->handleResponse($resetPass['response'],'update password success');
            }
            else {
              return   $this->handleError($resetPass['message'],null,422);
            }
       }
       else
       {
           return  $this->handleError($checkToGetData,'Unauthorization',422);
       }

    }

    public function profile(Request $request)
    {
        $checkToGetData = Auth::user($request->header('Authorization'));

        if($checkToGetData)
        {
            return  $this->handleResponse($checkToGetData,'show my profile admin success');
        }
        else
        {
            return  $this->handleError($checkToGetData,'Unauthorization',422);
        }
    }
    public function updateProfile(UpdateProfileAdminRequest $request)
    {
        $checkToGetData = Auth::user($request->header('Authorization'));

        if($checkToGetData)
        {
            $request->request->add(['id' => $checkToGetData->id]);
            $updateUsersAdmin =   $this->UpdateProfileService->updateProfileAdmin($request);

            if($updateUsersAdmin['status']) {
                return $this->handleResponse($updateUsersAdmin['response'],'update users admin success');
            }
            else {
                return $this->handleError($updateUsersAdmin['response'],'update users admin fail',422);
            }
        }
        else
        {
           return  $this->handleError($checkToGetData,'Unauthorization',422);
        }

    }

}
