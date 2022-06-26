<?php

namespace App\Services\RolesPermission;

use App\Models\User;
use App\Http\Controllers\BaseController;
/**
 * Class RemoveRoleAdmin.php
 * @package App\Services
 */
class RemoveRoleWeb extends BaseController 
{
    public function removeWeb($request) {
    
        $admin = User::find($request->id);
        if($admin) {
            $role =  $admin->removeRole($request->roleName);

            return $this->handleResponse($admin, 'remove Role user web Success');
        } 
        else {
            return $this->handleError($admin, 'web id not found');
        }
     
      
    }
}