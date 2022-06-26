<?php

namespace App\Services\AuthServices;
use App\Repositories\UsersAdminRepository;
use App\Repositories\UsersRepository;
/**
 * Class UpdateProfileService
 * @package App\Services
 */
class UpdateProfileService
{
    private $usersAdminRepositories;
    private $usersRepository;
   
    public function __construct(UsersAdminRepository $UrersAdminRepository,UsersRepository $usersRepository)
    {
            $this->usersAdminRepositories = $UrersAdminRepository; 
            $this->usersRepository        = $usersRepository;  
    }

    public function updateProfileAdmin($request) {
        
        return  $this->usersAdminRepositories->update($request);
    }
    public function updateProfile($request) {
        
        return  $this->usersRepository->update($request);
       
    }
}
