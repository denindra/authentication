<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersServices\UsersQuery;
use App\Services\UsersServices\UsersCommand;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UsersRequest\UsersCreateValidation;
use App\Http\Requests\UsersRequest\UsersDestroyValidation;
use App\Http\Requests\UsersRequest\UsersUpdateValidation;


class UsersController extends BaseController
{

     public function show(Request $request,UsersQuery $userQuery) {

        $showUsers =   $userQuery->show($request);

         if($showUsers['status']) {
             return $this->handleResponse($showUsers,'Show users  success',200);
         } else {
             return $this->handleError($showUsers,'Show users  fail',422);
         }
     }
     public function create(UsersCreateValidation $request,UsersCommand $userCommand) {

        $createUsers =  $userCommand->store($request);

         if($createUsers['status']) {
             return $this->handleResponse($createUsers,'Create users  success',200);
         } else {
             return $this->handleError($createUsers,'Create users  fail',422);
         }
     }
     public function destroy(UsersDestroyValidation $request,UsersCommand $userCommand) {

      $destroyUsers =  $userCommand->destroy($request);

         if($destroyUsers['status']) {
             return $this->handleResponse($destroyUsers,'Destroy users  success',200);
         } else {
             return $this->handleError($destroyUsers,'Destroy users  fail',422);
         }

     }
     public function update(UsersUpdateValidation $request,UsersCommand $userCommand) {

      $updateUsers =  $userCommand->update($request);

         if($updateUsers['status']) {
             return $this->handleResponse($updateUsers,'Update users  success',200);
         } else {
             return $this->handleError($updateUsers,'Update users  fail',422);
         }

     }
}
