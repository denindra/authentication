<?php

namespace App\Services\RolesPermission;

use App\Http\Controllers\BaseController;
use \Spatie\Permission\Exceptions\PermissionDoesNotExist;
use App\Models\User;

/**
 * Class AssignpermissionWeb
 * @package App\Services
 */
class AssignpermissionWeb extends BaseController 
{
public function assignPermissionWeb($request) {
    
        $user = User::find($request->id);

        if($user) {
                
                try 
                {
                    $permission =  $user->givePermissionTo($request->permissionName);
                } 
                catch(PermissionDoesNotExist) 
                {
                    return $this->handleError([], 'there is no permission Web exist with that name',422);
                }
            
            if($permission) {

                return $this->handleResponse($permission, 'permission web insert successfuly');

            } else {
                
                return $this->handleError($permission, 'error permission web action',422);
            }
        } 
        else {
        
            return $this->handleError($user, 'users web not found, please try other id',422);
        }
 

    }   
}
