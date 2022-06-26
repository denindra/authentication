<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersAdminRequest\UsersAdminCreateValidation;
use App\Http\Requests\UsersAdminRequest\UsersAdminUpdateValidation;
use App\Http\Requests\UsersAdminRequest\UsersAdminDestroyValidation;
use App\Services\UsersAdminServices\UserAdminCommand;
use Illuminate\Http\Request;
use App\Services\UsersAdminServices\UserAdminQuery;

class UsersAdminController extends Controller
{
   
    public function show(Request $request,UserAdminQuery $userQuery) {
    
        return  $userQuery->show($request); 
     }
     public function create(UsersAdminCreateValidation $request,UserAdminCommand $userAdminCommand) {
     
        return $userAdminCommand->store($request); 
     }
     public function destroy(UsersAdminDestroyValidation $request,UserAdminCommand $userAdminCommand) {

      return $userAdminCommand->destroy($request);
     }
     public function update(UsersAdminUpdateValidation $request,UserAdminCommand $userAdminCommand) {
     
      return $userAdminCommand->update($request);
     }
}
