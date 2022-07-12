<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersAdminRequest\UsersAdminCreateValidation;
use App\Http\Requests\UsersAdminRequest\UsersAdminUpdateValidation;
use App\Http\Requests\UsersAdminRequest\UsersAdminDestroyValidation;
use App\Services\UsersAdminServices\UserAdminCommand;
use Illuminate\Http\Request;
use App\Services\UsersAdminServices\UserAdminQuery;

class UsersAdminController extends BaseController
{

    public function show(Request $request,UserAdminQuery $userQuery) {

        $getUserData =   $userQuery->show($request);

        if($getUserData['status']) {
            return $this->handleResponse($getUserData,'Show users admin success',200);
        } else {
            return $this->handleError($getUserData,'Show users admin fail',422);
        }

     }
     public function create(UsersAdminCreateValidation $request,UserAdminCommand $userAdminCommand) {

        $createAdmin =  $userAdminCommand->store($request);

        if($createAdmin['status']) {
            return $this->handleResponse($createAdmin,'Create users admin success',200);
        } else {
            return $this->handleError($createAdmin,'Create users admin fail',422);
        }

     }
     public function destroy(UsersAdminDestroyValidation $request,UserAdminCommand $userAdminCommand) {

        $destroyAdmin =  $userAdminCommand->destroy($request);

        if($destroyAdmin['status']) {
             return $this->handleResponse($destroyAdmin,'Destroy users admin success',200);
        } else {
             return $this->handleError($destroyAdmin,'Destroy users admin fail',422);
        }

     }
     public function update(UsersAdminUpdateValidation $request,UserAdminCommand $userAdminCommand) {

        $updateAdmin = $userAdminCommand->update($request);

        if($updateAdmin['status']) {
             return $this->handleResponse($updateAdmin,'Update users admin success',200);
        } else {
             return $this->handleError($updateAdmin,'Update users admin fail',422);
        }

     }
}
