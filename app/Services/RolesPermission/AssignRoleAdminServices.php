<?php

namespace App\Services\RolesPermission;

use App\Models\Admin;
use App\Http\Controllers\BaseController;
use \Spatie\Permission\Exceptions\RoleDoesNotExist;

/**
 * Class AssignRoleAdminServices
 * @package App\Services
 */
class AssignRoleAdminServices extends BaseController 
{
    public function assignRoleAdmin($request) {

        $admin = Admin::find($request->id);

        if($admin) {
                
                try 
                {
                    $role =  $admin->assignRole($request->roleName);
                } 
                catch(RoleDoesNotExist) 
                {
                    return response()->json([
                        'responseMessage' => 'there is no roles Admin exist with that name',
                        'roles-name' => $request->roleName,
                        'responseStatus'  => 403,
                    ]);
                }
            
            if($role) {

                return $this->handleResponse($role, 'Roles admin insert successfuly');

            } else {
                
                return $this->handleError($role, 'error role admin action',422);
            }
        } 
        else {
          
            return $this->handleError($admin, 'users admin not found, please try other id',422);
        }
     
    }
    
}
