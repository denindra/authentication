<?php

namespace App\Services\UsersAdminServices;

use App\Http\Controllers\BaseController;
use App\Repositories\UsersAdminRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserAdminCommand
 * @package App\Services
 */
class UserAdminCommand extends BaseController
{
    private $usersAdminRepositories;
   
    public function __construct(UsersAdminRepository $UrersAdminRepository)
    {
            $this->usersAdminRepositories = $UrersAdminRepository;  
    }

    public function store($request) {

       return  $this->usersAdminRepositories->store($request);
    }
    public function destroy($requestId) {
       
        return  $this->usersAdminRepositories->destroy($requestId);
    }
    public function update($requestId) {
    
        return  $this->usersAdminRepositories->update($requestId);
    }
   
}
