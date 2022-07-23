<?php

namespace App\Services\RolesPermission;

use App\Http\Controllers\BaseController;
use \Spatie\Permission\Exceptions\PermissionDoesNotExist;
use App\Models\Admin;

/**
 * Class AssignPermissionAdminServices
 * @package App\Services
 */
class AssignPermissionAdminServices extends BaseController
{

    public function AssignPermissionAdmin($request) {

        $user = Admin::find($request->id);

        if($user) {
                try
                {
                    $permission =  $user->givePermissionTo($request->permissionName);
                }
                catch(PermissionDoesNotExist)
                {
                    return $this->handleArrayErrorResponse([], 'there is no permission Admin exist with that name',422);
                }

            if($permission) {
                return $this->handleArrayResponse($permission, 'permission Admin insert successfuly');

            } else {
                return $this->handleArrayErrorResponse($permission, 'error permission Admin action',422);
            }
        }
        else {
            return $this->handleArrayErrorResponse($user, 'users Admin not found, please try other id',422);
        }

    }
}
