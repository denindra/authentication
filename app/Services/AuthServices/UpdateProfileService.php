<?php

namespace App\Services\AuthServices;

use App\Http\Controllers\BaseController;
use App\Interfaces\UsersInterface;
use App\Interfaces\UsersAdminInterface;
/**
 * Class UpdateProfileService
 * @package App\Services
 */
class UpdateProfileService extends BaseController
{
    private $usersAdminInterfaces;
    private $usersInterfaces;

    public function __construct(UsersAdminInterface $usersAdminInterfaces,UsersInterface $usersInterfaces)
    {
            $this->usersAdminInterfaces = $usersAdminInterfaces;
            $this->usersInterfaces        = $usersInterfaces;
    }

    public function updateProfileAdmin($request) {

        $updateProfileAdmin =   $this->usersAdminInterfaces->update($request);

        if($updateProfileAdmin['queryStatus']) {
            return $this->handleArrayResponse($updateProfileAdmin['response'],'update profile user success');
        } else {
            return $this->handleArrayErrorResponse($updateProfileAdmin,'update profile users fail');
        }
    }
    public function updateProfile($request) {

        $updateProfile =   $this->usersInterfaces->update($request);

        if($updateProfile['queryStatus']) {
            return $this->handleArrayResponse($updateProfile['response'],'update profile user success');
        } else {
            return $this->handleArrayErrorResponse($updateProfile,'update profile users fail');
        }

    }
}
