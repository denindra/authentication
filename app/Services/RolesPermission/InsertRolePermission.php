<?php

namespace App\Services\RolesPermission;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\BaseController;
/**
 * Class InserRolePermission
 * @package App\Services
 */
class InsertRolePermission extends BaseController 
{
    public function insertRolePermission($rolesAction) {

        foreach( $rolesAction as $addRoles) {
           
            $rolesId = Role::insertGetId([
                'name'           => $addRoles['name'],
                'guard_name'     => $addRoles['guard_name'],
                'created_at'     =>now(),
                'updated_at'     =>now(),
            ]);
           
           foreach($addRoles['permission'] as $addPermission) {

                $permissionPaket = array(
                    'name'           => $addPermission['name'],
                    'guard_name'     => $addPermission['guard_name'],
                    'created_at'     =>now(),
                    'updated_at'     =>now(),
                );
                
                Permission::create($permissionPaket);
                
                $role =  Role::find($rolesId);
                $role->givePermissionTo([
                    'name'           => $addPermission['name'],
                ]);
           }
        }

        return $this->handleResponse('check your DB for more detail', 'initiate Roles successfuly');
    }
}
