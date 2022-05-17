<?php
   
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Services\AuthServices\LoginByEmailService;
use App\Services\AuthServices\ResetPasswordService;
use App\Http\Requests\AuthRequest\ResetPasswordRequest;
use App\Http\Requests\AuthRequest\ResetNewPasswordRequest;

class AuthController extends BaseController
{
  
    private $LoginByEmailService;
    private $ResetPasswordService;
  //  private $ResetPasswordService;

    public function __construct(LoginByEmailService $LoginByEmailService,ResetPasswordService $ResetPasswordService,)
    {
            $this->LoginByEmailService        = $LoginByEmailService;
            $this->ResetPasswordService       = $ResetPasswordService;
            //$this->ResetPasswordService       = $ResetPasswordService;
    }

    public function login(Request $request)
    {
        return $this->LoginByEmailService->userNamePassword($request);
    }
    public function logout(Request $request)
    {
        $checkToGetData = Auth::user($request->header('Authorization'));
        
        if($checkToGetData)
        {
            return  Auth::user($request->header('Authorization'))->tokens()->delete();   
        }
        else
        {
            return  $this->handleError($checkToGetData,422);
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
    public function changePassword(Request $request)
    {

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
   
}