<?php

namespace App\Services\AuthServices;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UsersAdminRepository;
use App\Repositories\UsersRepository;
/**
 * Class ChangePasswordService
 * @package App\Services
 */
class ChangePasswordService extends BaseController
{
    private $usersAdminRepositories;
    private $usersRepository;
   
    public function __construct(UsersAdminRepository $usersAdminRepositories,UsersRepository $usersRepository)
    {
            $this->usersAdminRepositories = $usersAdminRepositories;  
            $this->usersRepository = $usersRepository;  
    }
    
    public function updatePassword($request) {

        //checking current password
        $checkCurrPassword =  Hash::check($request->current_password, auth()->user()->password);

        if(!$checkCurrPassword) {

            return $this->handleError($checkCurrPassword, 'current password is wrong,please try again');
        }
        
        return  $this->usersRepository->updatePassword($request);
    }
    public function updatePasswordAdmin($request) {

        //checking current password
        $checkCurrPassword =  Hash::check($request->current_password, auth()->user()->password);

        if(!$checkCurrPassword) {

            return $this->handleError($checkCurrPassword, 'current password admin is wrong,please try again');
        }
        
        return  $this->usersAdminRepositories->updatePasswordAdmin($request);
    }
}
