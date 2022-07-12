<?php

namespace App\Services\AuthServices;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;


class LoginByEmailService  extends BaseController
{

    public function userNamePassword($request) {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $auth                = Auth::user();

            $success['token']    =  $auth->createToken('loginAsUsers', ['privateWeb'])->plainTextToken;
            $success['name']     =  $auth->name;

            return $this->handleArrayResponse($success,'success login users');
        }
        else
        {
            return $this->handleArrayErrorResponse('Unauthorised','email or password users  not correct');
        }
    }
    public function userNamePasswordAdmin($request) {

        if(Auth::guard('Admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::guard('Admin')->user();

            $success['token'] = $auth->createToken('loginAsAdmin', ['privateAdmin'])->plainTextToken;
            $success['name'] = $auth->name;

            return $this->handleArrayResponse($success,'success login admin');
        }
        else
        {
            return $this->handleArrayErrorResponse('Unauthorised','email or password admin not correct');
        }
    }
}
