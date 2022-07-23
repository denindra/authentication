<?php
namespace App\Http\Traits\RolesAndPermissionTraits;

trait RolesWebTraits {

    public function RolesWeb() {
        $guardName = 'web';

        $rolesPermissionList = array(
            'rolePermissionWeb' =>[
               [
                'name' =>'web-manage-account',
                'guard_name'=>$guardName,
                'permission'=>  [
                    [
                        'name' => 'web-login',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'web-account-myprofile',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'web-account-changePassword',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'web-account-logout',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'web-account-updateProfile',
                        'guard_name' => $guardName,
                    ],

                ],
            ],
        ],
    );

        return $rolesPermissionList;

    }
}
