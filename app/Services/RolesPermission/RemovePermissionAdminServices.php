<?php

namespace App\Services\RolesPermission;

use App\Http\Controllers\BaseController;
use App\Models\Admin;

/**
 * Class RemovePermissionAdminServices
 * @package App\Services
 */
class RemovePermissionAdminServices extends BaseController
{
    public function RemovePermissionAdmin($request) {

        $user = Admin::find($request->id);
        if($user) {
            $role =  $user->revokePermissionTo($request->permissionName);

            return $this->handleArrayResponse($user, 'remove permission web Success');
        }
        else {
            return $this->handleArrayErrorResponse($user, 'web id not found');
        }
    }
}
