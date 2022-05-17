<?php

namespace App\Services\UsersServices;

use App\Repositories\UsersRepository;
use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;

class UsersQuery extends BaseController
{
    public $usersRepositories;

    public function __construct(UsersRepository $usersRepositories)
    {
            $this->usersRepositories = $usersRepositories;
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
       $getData =  $this->usersRepositories->show($request,$getColumn);

        return $getData;
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
