<?php

namespace App\Services\UsersAdminServices;

use App\Repositories\UsersAdminRepository;
use App\Http\Controllers\BaseController;
/**
 * Class UserAdminQuery
 * @package App\Services
 */
class UserAdminQuery  extends BaseController
{

    public $usersAdminRepositories;

    public function __construct(UsersAdminRepository $usersAdminRepositories)
    {
            $this->usersAdminRepositories = $usersAdminRepositories;
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
       $getData =  $this->usersAdminRepositories->show($request,$getColumn);

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
