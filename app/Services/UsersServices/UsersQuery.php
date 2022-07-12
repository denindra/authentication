<?php

namespace App\Services\UsersServices;

use App\Interfaces\UsersInterface;
use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;

class UsersQuery extends BaseController
{
    private $usersInterfaces;

    public function __construct(UsersInterface $usersInterfaces)
    {
            $this->usersInterfaces = $usersInterfaces;
    }

    public function show($request) {

        if($request->CollectionType == 'usersListWeb') {

            $getColumn =  $this->usersListWeb();
        }
        else if($request->CollectionType == 'usersSummaryWeb') {

            $getColumn = $this->usersSummaryWeb();
        }
        else {

            $getColumn =  $this->showTypeAll();
        }

        // call repo
       $getData =  $this->usersInterfaces->show($request,$getColumn);

        if($getData['queryStatus']) {
            return $this->handleArrayResponse($getData['response'],'get data users success');
        } else {
            return $this->handleArrayErrorResponse( $getData['response'],'get data users fail');
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
    public function showTypeAll()
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
