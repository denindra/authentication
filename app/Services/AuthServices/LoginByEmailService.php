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
   
            return $this->handleResponse($success, 'success login users');
        } 
        else
        { 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised users'],404);
        } 
    }
    public function userNamePasswordAdmin($request) {
  
        if(Auth::guard('Admin')->attempt(['email' => $request->email, 'password' => $request->password]))
        { 
            $auth                = Auth::guard('Admin')->user(); 

            $success['token']    =  $auth->createToken('loginAsAdmin', ['privateAdmin'])->plainTextToken; 
            $success['name']     =  $auth->name;
   
            return $this->handleResponse($success, 'success login admin');
        } 
        else
        { 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised admin'],404);
        } 
    }
}
