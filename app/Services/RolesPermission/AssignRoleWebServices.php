<?php

namespace App\Services\RolesPermission;

use App\Models\User;
use App\Http\Controllers\BaseController;
use \Spatie\Permission\Exceptions\RoleDoesNotExist;
/**
 * Class AssignRoleWebServices
 * @package App\Services
 */
class AssignRoleWebServices extends BaseController 
{
    public function assignRoleWeb($request) {

        $web = User::find($request->id);

        if($web) {
                
                try 
                {
                    $role =  $web->assignRole($request->roleName);
                } 
                catch(RoleDoesNotExist) 
                {
                    return response()->json([
                        'responseMessage' => 'there is no roles Web exist with that name',
                        'roles-name' => $request->roleName,
                        'responseStatus'  => 403,
                    ]);
                }
            
            if($role) {

                return $this->handleResponse($role, 'Roles web insert successfuly');

            } else {
                
                return $this->handleError($role, 'error role web action',422);
            }
        } 
        else {
          
            return $this->handleError($web, 'users web not found, please try other id',422);
        }
     
    }
}
