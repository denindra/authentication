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
                    return $this->handleArrayErrorResponse($request->roleName,'false');
                }

            if($role) {

                return $this->handleArrayResponse($role,'Roles admin insert successfuly');


            } else {
                return $this->handleArrayErrorResponse($request->roleName,'error role admin action');

            }
        }
        else {

            return $this->handleError($admin, 'users admin not found, please try other id',422);
        }

    }

}
