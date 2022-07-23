<?php

namespace App\Services\RolesPermission;


use App\Http\Controllers\BaseController;
use App\Models\Admin;

/**
 * Class RemoveRoleAdmin.php
 * @package App\Services
 */
class RemoveRoleAdmin extends BaseController
{

    public function removeAdmin($request) {

        $admin = Admin::find($request->id);
        if($admin) {
            $role =  $admin->removeRole($request->roleName);

            return $this->handleArrayResponse($admin, 'remove Role admin Success');
        }
        else {
            return $this->handleArrayErrorResponse($admin, 'admin id not found');
        }


    }
}
