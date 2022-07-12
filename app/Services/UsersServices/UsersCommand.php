<?php

namespace App\Services\UsersServices;

use App\Interfaces\UsersInterface;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UsersCreateValidation;

class UsersCommand extends BaseController {

    private $usersInterfaces;

    public function __construct(UsersInterface $usersInterfaces)
    {
            $this->usersInterfaces = $usersInterfaces;
    }

    public function store($request) {

       $storeUser =   $this->usersInterfaces->store($request);

        if($storeUser['queryStatus']) {
            return $this->handleArrayResponse($storeUser['response'],'Store users  success');
        } else {
            return $this->handleArrayErrorResponse( $storeUser['response'],'Store users  fail');
        }
    }
    public function destroy($requestId) {

        $destroyUser =   $this->usersInterfaces->destroy($requestId);

        if($destroyUser['queryStatus']) {
            return $this->handleArrayResponse($destroyUser['response'],'Destroy users  success');
        } else {
            return $this->handleArrayErrorResponse( $destroyUser['response'],'Destroy users  fail');
        }

    }
    public function update($requestId) {

        $updateUser =   $this->usersInterfaces->update($requestId);

        if($updateUser['queryStatus']) {
            return $this->handleArrayResponse($updateUser['response'],'Update users  success');
        } else {
            return $this->handleArrayErrorResponse( $updateUser['response'],'Update users  fail');
        }

    }

}
