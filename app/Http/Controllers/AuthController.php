<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest\LoginUsersRequest;
use App\Http\Requests\AuthRequest\ValidateVerificationAccountRequestUsers;
use App\Interfaces\UsersInterface;
use App\Mail\AccountVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthServices\LoginByEmailService;
use App\Services\AuthServices\ResetPasswordService;
use App\Http\Requests\AuthRequest\ResetPasswordRequest;
use App\Http\Requests\AuthRequest\ResetNewPasswordRequest;
use App\Http\Requests\AuthRequest\UpdateProfileUsersRequest;
use App\Http\Requests\UsersRequest\ChangePasswordRequest;
use App\Services\AuthServices\ChangePasswordService;
use App\Services\AuthServices\UpdateProfileService;
use App\Services\OtpServices;
use Illuminate\Support\Facades\Mail;


class AuthController extends BaseController
{

    private $LoginByEmailService;
    private $ResetPasswordService;
    private $ChangePasswordService;
    private $UpdateProfileService;
    private $OtpServices;
    private $usersInterfaces;


    public function __construct(
        LoginByEmailService $LoginByEmailService,
        ResetPasswordService $ResetPasswordService,
        ChangePasswordService $ChangePasswordService,
        UpdateProfileService  $UpdateProfileService,
        OtpServices  $OtpServices,
        UsersInterface $usersInterfaces
    )
    {
            $this->LoginByEmailService        = $LoginByEmailService;
            $this->ResetPasswordService       = $ResetPasswordService;
            $this->ChangePasswordService      = $ChangePasswordService;
            $this->UpdateProfileService       = $UpdateProfileService;
            $this->OtpServices                = $OtpServices;
            $this->usersInterfaces            = $usersInterfaces;

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
    /**
     * @lrd:start
     * # routes email verification hanya dapat dilakukan 1 menit sekali, konfigurasinya ada di route service provider
     * # email verification menggunakan 4 digit dan harus dalam keadaan login
     *
     * @lrd:end
     */
    public function AccountVerificationEmail(Request $request) {

        $checkToGetData = Auth::user($request->header('Authorization'));
        if($checkToGetData)
        {
            if($request->user()->hasVerifiedEmail()) {
                return $this->handleResponse($checkToGetData,'email has been verify');
            }

            $getOtp =  $this->OtpServices->generateOTP($request->user()->email);

            if($getOtp['status']) {

                    //send email
                    $data = array(
                        'OtpToken'   => $getOtp['response']['otp'],
                        'email'      => $request->user()->email,
                        'name'       => $request->user()->name,
                        'expiredAt'  => $getOtp['response']['expiredOTP']
                    );

                    try {
                          $sendverificationMail =   Mail::to($request->user()->email)->queue(new AccountVerificationMail($data));
                          return $this->handleResponse(null,'OTP has been send to your email');
                    }
                    catch (Throwable $e) {
                      return  $this->handleError($sendverificationMail,'fail when sending OTP to email',422);
                    }

            }

            return  $this->handleError($getOtp['response'],'generate OTP Fail',422);
        }
        else {
            return  $this->handleError($checkToGetData,'Unauthorization',422);
        }


    }
    public function validateVerificationAccount(ValidateVerificationAccountRequestUsers $request) {

        $checkToGetDataUsers = Auth::user($request->header('Authorization'));

        if($checkToGetDataUsers) {

            if(Auth::user()->hasVerifiedEmail()) {
                return $this->handleResponse($checkToGetDataUsers,'account has been verify');
            }

            $getOtp = $request->otp;
            $validate =  $this->OtpServices->validateOTP($getOtp,$request->user()->email);

            if($validate['status']) {
                //update user

                $myRequest = new Request();
                $myRequest->setMethod('POST');
                $myRequest->request->add([
                    'id'   => $checkToGetDataUsers->id,
                    'email'=> $checkToGetDataUsers->email,
                    'name' => $checkToGetDataUsers->name,
                    'accountVerifyAt' => now(),
                ]);


                $updateUser =      $this->usersInterfaces->update($myRequest);


                if(!$updateUser['queryStatus']) {

                    return  $this->handleError($updateUser,'Update verification fail',422);
                }

                return $this->handleResponse($updateUser ,'update verify user success');


                //update user verified date

            }

            return  $this->handleError($validate['response'],'OTP validate Fail/expired',422);

        } else {
            return  $this->handleError($checkToGetDataUsers,'Unauthorization',422);
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
