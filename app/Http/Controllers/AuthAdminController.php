<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
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

    public function __construct(LoginByEmailService $LoginByEmailService,ResetPasswordService $ResetPasswordService,ChangePasswordService $ChangePasswordService,UpdateProfileService  $UpdateProfileService)
    {
            $this->LoginByEmailService        = $LoginByEmailService;
            $this->ResetPasswordService       = $ResetPasswordService;
            $this->ChangePasswordService      = $ChangePasswordService;
            $this->UpdateProfileService       = $UpdateProfileService;
          
    }
    public function login(Request $request)
    {
        return $this->LoginByEmailService->userNamePasswordAdmin($request);
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
            return  $this->handleError($checkToGetData,422);
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
                return   $this->ChangePasswordService->updatePasswordAdmin($request);
           }  
           else
           {
               return  $this->handleError($checkToGetData,422);
           }

    }
  
    public function profile(Request $request)
    {   
        $checkToGetData = Auth::user($request->header('Authorization'));
        
        if($checkToGetData)
        {
            return $checkToGetData;
        }
        else
        {
            return  $this->handleError($checkToGetData,422);
        }
    }
    public function updateProfile(UpdateProfileAdminRequest $request)
    {
        $checkToGetData = Auth::user($request->header('Authorization'));
       
        if($checkToGetData)
        {
            $request->request->add(['id' => $checkToGetData->id]);
            return   $this->UpdateProfileService->updateProfileAdmin($request);
        }
        else
        {
           return  $this->handleError($checkToGetData,422);
        }

    }

}
