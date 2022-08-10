<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Services\AuthServices\LoginByEmailService;
use App\Services\AuthServices\ResetPasswordService;
use App\Http\Requests\AuthRequest\ResetPasswordRequest;
use App\Http\Requests\AuthRequest\ResetNewPasswordRequest;
use App\Http\Requests\AuthRequest\UpdateProfileAdminRequest;
use App\Http\Requests\AuthRequest\UpdateProfileUsersRequest;
use App\Http\Requests\UsersRequest\ChangePasswordRequest;
use App\Services\AuthServices\ChangePasswordService;
use App\Services\AuthServices\UpdateProfileService;

class AuthController extends BaseController
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

    public function login(LoginUsersRequest $request)
    {

        $loginUser = $this->LoginByEmailService->userNamePassword($request);

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
            $deleteAccount =   Auth::user($request->header('Authorization'))->tokens()->delete();

            return  $this->handleResponse('Response : '.$deleteAccount,'logout success');
        }
        else
        {
            return  $this->handleError($checkToGetData,'Unauthorization',422);
        }

    }
    public function resetPassword(ResetPasswordRequest $request ) {

        return  $this->ResetPasswordService->resetPassword($request);

    }
    public function resetNewPassword(ResetNewPasswordRequest $request) {

        return  $this->ResetPasswordService->resetNewPassword($request);

    }
    public function AccountVerificationEmail(Request $request) {

        if($request->user()->hasVerifiedEmail()) {

        }
    }
    public function changePassword(ChangePasswordRequest $request) {

        $checkToGetData = Auth::user($request->header('Authorization'));

        if($checkToGetData)
        {

            $request->request->add(['id' => $checkToGetData->id]);
            $resetPass  =   $this->ChangePasswordService->updatePassword($request);
            if($resetPass['status']) {

                return $this->handleResponse($resetPass['response'],'update password success');
            }
            else {

                return $this->handleError($resetPass['message'],null,422);
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
           return  $this->handleResponse($checkToGetData,'show my profile users success');
        }
        else
        {
           return  $this->handleError($checkToGetData,'Unauthorization',422);
        }
    }
    public function updateProfile(UpdateProfileUsersRequest $request)
    {

        $checkToGetData = Auth::user($request->header('Authorization'));

        if($checkToGetData)
        {
            $request->request->add(['id' => $checkToGetData->id]);
            $updateUsers =    $this->UpdateProfileService->updateProfile($request);

            if($updateUsers['status']) {
                return $this->handleResponse($updateUsers['response'],'update users success');
            }
            else {
                return $this->handleError($updateUsers['response'],'update users fail',422);
            }

        }
        else
        {
           return  $this->handleError($checkToGetData,'Unauthorization',422);
        }
    }
}
