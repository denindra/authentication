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
            $success['token']    =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
            $success['name']     =  $auth->name;
   
            return $this->handleResponse($success, 'success login');
        } 
        else
        { 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised'],404);
        } 
    }
}
