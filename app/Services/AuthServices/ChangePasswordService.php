<?php

namespace App\Services\AuthServices;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\UsersInterface;
use App\Interfaces\UsersAdminInterface;
/**
 * Class ChangePasswordService
 * @package App\Services
 */
class ChangePasswordService extends BaseController
{
    private $usersAdminInterfaces;
    private $usersInterfaces;

    public function __construct(UsersAdminInterface $usersAdminInterfaces,UsersInterface $usersInterfaces)
    {
            $this->usersAdminInterfaces = $usersAdminInterfaces;
            $this->usersInterfaces = $usersInterfaces;
    }

    public function updatePassword($request) {

        //checking current password
        $checkCurrPassword =  Hash::check($request->current_password, auth()->user()->password);

        if(!$checkCurrPassword) {

            return $this->handleArrayErrorResponse($checkCurrPassword, 'current password is wrong,please try again');
        }

        $updatePasswordAdmin =   $this->usersInterfaces->updatePassword($request);

        return $this->handleArrayResponse($updatePasswordAdmin['response'],'update password success');
    }
    public function updatePasswordAdmin($request) {

        //checking current password
        $checkCurrPassword =  Hash::check($request->current_password, auth()->user()->password);

        if(!$checkCurrPassword) {
            return $this->handleArrayErrorResponse($checkCurrPassword, 'current password admin is wrong,please try again');
        }

        $updatePasswordUsers =   $this->usersAdminInterfaces->updatePasswordAdmin($request);
        return $this->handleArrayResponse($updatePasswordUsers['response'],'update password success');
    }
}
