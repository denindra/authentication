<?php
namespace App\Http\Traits\RolesAndPermissionTraits;

trait RolesAdminTraits {
  /*
  RolesAdmin traits hanya dapat di lakukan 
    - apabila model_has_role  / model_has_permission masih kosong
    - apabila toutes belum di setup middlewarenya

    karena di takutkan apabila berbeda namanya maka tidak kebaca, karena format name itu unik mana di beri format sbgai berikut
    {guardname}-{namamodul}-{nama permission}
    agar tidak bingung

  */
    public function RolesAdmin() {
        $guardName = 'Admin';

        $rolesPermissionList = array(
            'rolePermissionAdmin' =>[
               [
                'name' =>'admin-account',
                'guard_name'=>$guardName,
                'permission'=>  [
                    [
                        'name' => 'admin-login',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-account-myprofile',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-account-changePassword',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-account-logout',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-account-updateProfile',
                        'guard_name' => $guardName,
                    ],
 
                ],
            ],
            [
                'name' =>'admin-users',
                'guard_name'=>$guardName,
                'permission'=>  [
                    [
                        'name' => 'admin-users-create',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-users-update',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-users-show',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-users-delete',
                        'guard_name' => $guardName,
                    ],
                    
                ],
            ],
            [
                'name' =>'admin-usersRoles',
                'guard_name'=>$guardName,
                'permission'=>  [
                    [
                        'name' => 'admin-usersRoles-create',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersRoles-update',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersRoles-show',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersRoles-delete',
                        'guard_name' => $guardName,
                    ],
                    
                ],
            ],
            [
                'name' =>'admin-usersWeb',
                'guard_name'=>$guardName,
                'permission'=>  [
                    [
                        'name' => 'admin-usersWeb-create',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersWeb-update',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersWeb-delete',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersWeb-show',
                        'guard_name' => $guardName,
                    ],
                ],
            ], 
            [
                'name' =>'admin-usersWebRoles',
                'guard_name'=>$guardName,
                'permission'=>  [
                    [
                        'name' => 'admin-usersWebRoles-create',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersWebRoles-update',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersWebRoles-delete',
                        'guard_name' => $guardName,
                    ],
                    [
                        'name' =>  'admin-usersWebRoles-show',
                        'guard_name' => $guardName,
                    ],
                ],
            ], 
        ],
           
    );

        return $rolesPermissionList;
        
    }
}