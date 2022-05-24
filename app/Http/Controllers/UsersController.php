<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UsersServices\UsersQuery;
use App\Services\UsersServices\UsersCommand;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\UsersRequest\UsersCreateValidation;
use App\Http\Requests\UsersRequest\UsersDestroyValidation;
use App\Http\Requests\UsersRequest\UsersUpdateValidation;


class UsersController extends Controller 
{

     public function show(Request $request,UsersQuery $userQuery) {
      
        return  $userQuery->show($request);
       
     }
     public function create(UsersCreateValidation $request,UsersCommand $userCommand) {
      
        return $userCommand->store($request);
     
     }
     public function destroy(UsersDestroyValidation $request,UsersCommand $userCommand) {
     
      return $userCommand->destroy($request);
     }
     public function update(UsersUpdateValidation $request,UsersCommand $userCommand) {
     
      return $userCommand->update($request);
     }
}
