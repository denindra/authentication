<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
                        ->forgetCachedPermissions();

        $adminLogin = 'admin-login';
        $userLogin  = 'user-login';

        //manage login permission
        Permission::create(['name' => $adminLogin]);
        Permission::create(['name' => $userLogin]);

        //define roles availabe
        $superAdmin = 'super-admin';
        $webAdmin   = 'web-admin';
        $webUser    = 'web-user';

        //Role
        // this can be done as separate statements
        Role::create(['name' => $superAdmin])
                        ->givePermissionTo(Permission::all());
        
        Role::create(['name' => $webAdmin])
                        ->givePermissionTo([
                            $adminLogin
                        ]);

        Role::create(['name' => $webUser])
                        ->givePermissionTo([
                            $userLogin
                        ]);


    }
}
