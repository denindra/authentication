<?php

namespace App\Services\RolesPermission;

use App\Http\Controllers\BaseController;
use App\Models\User;

/**
 * Class RemovePermissionWebServices
 * @package App\Services
 */
class RemovePermissionWebServices extends BaseController
{
    public function RemovePermissionWeb($request) {

        $user = User::find($request->id);
        if($user) {
            $role =  $user->revokePermissionTo($request->permissionName);

            return $this->handleArrayResponse($user, 'remove permission web Success');
        }
        else {
            return $this->handleArrayErrorResponse($user, 'web id not found');
        }
    }
}
