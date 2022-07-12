<?php

namespace App\Services\UsersAdminServices;

use App\Http\Controllers\BaseController;
use App\Interfaces\UsersAdminInterface;


/**
 * Class UserAdminCommand
 * @package App\Services
 */
class UserAdminCommand extends BaseController
{
    private $usersAdminRepositoriesInterfaces;

    public function __construct(UsersAdminInterface $usersAdminRepositoriesInterfaces)
    {
            $this->usersAdminRepositoriesInterfaces = $usersAdminRepositoriesInterfaces;
    }

    public function store($request) {

       $storeData =   $this->usersAdminRepositoriesInterfaces->store($request);

       if($storeData['queryStatus']) {
          return  $this->handleArrayResponse($storeData['response'],'store users admin success');
       } else {
           return $this->handleArrayErrorResponse($storeData['response'],'store users admin fail');
       }

    }
    public function destroy($requestId) {

        $destroyAdmin  =  $this->usersAdminRepositoriesInterfaces->destroy($requestId);

        if($destroyAdmin['queryStatus']) {
            return $this->handleArrayResponse($destroyAdmin['response'],'destory users admin success');

        } else {
            return $this->handleArrayErrorResponse( $destroyAdmin['response'],'destory users admin fail');
        }

    }
    public function update($requestId) {

        $updateUsers =   $this->usersAdminRepositoriesInterfaces->update($requestId);

        if($updateUsers['queryStatus']) {
            return $this->handleArrayResponse($updateUsers['response'],'update users admin success');

        } else {
            return $this->handleArrayErrorResponse($updateUsers['response'],'update users admin fail');
        }

    }

}
