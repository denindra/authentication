<?php

namespace App\Services\UsersAdminServices;


use App\Interfaces\UsersAdminInterface;
use App\Http\Controllers\BaseController;
/**
 * Class UserAdminQuery
 * @package App\Services
 */
class UserAdminQuery  extends BaseController
{

    private $usersAdminRepositories;

    public function __construct(UsersAdminInterface $usersAdminRepositories)
    {
            $this->usersAdminRepositories = $usersAdminRepositories;
    }
    public function show($request) {

        if($request->CollectionType == 'usersListAdmin') {

            $getColumn =  $this->usersListWeb();
        }
        else if($request->CollectionType == 'usersSummaryAdmin') {

            $getColumn = $this->usersSummaryWeb();
        }
        else {

            $getColumn =  $this->showAll();
        }

        // call repo
       $getData =  $this->usersAdminRepositories->show($request,$getColumn);

        if($getData['queryStatus']) {
            return $this->handleArrayResponse($getData['response'],'get data users admin success');
        } else {
            return $this->handleArrayErrorResponse($getData['response'],'get data users admin fail');
        }
    }
    public function usersListWeb()
    {
          $selectOnlyColumn = [
              'id',
              'uuid',
              'name',
              'email',
              'password'
          ];

          return $selectOnlyColumn;
    }
    public function showAll()
    {
          $selectOnlyColumn = ['*'];

          return $selectOnlyColumn;
    }
    public function usersSummaryWeb() {

        $selectOnlyColumn = [
            'id',
            'name',
        ];

        return $selectOnlyColumn;

    }
}
