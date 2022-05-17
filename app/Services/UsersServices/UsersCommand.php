<?php

namespace App\Services\UsersServices;

use App\Repositories\UsersRepository;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UsersCreateValidation;

class UsersCommand extends BaseController {

    private $usersRepositories;
   
    public function __construct(UsersRepository $usersRepositories)
    {
            $this->usersRepositories = $usersRepositories;  
    }

    public function store($request) {

       return  $this->usersRepositories->store($request);
    }
    public function destroy($requestId) {
       
        return  $this->usersRepositories->destroy($requestId);
    }
    public function update($requestId) {
    
        return  $this->usersRepositories->update($requestId);
    }

}