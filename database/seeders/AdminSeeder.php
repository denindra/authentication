<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
            Admin::factory()->count(1)
            ->create()
            ->each(
                function($user) {
                    $user->assignRole('super-admin');
                }
            );
        
            Admin::factory()->count(1)
            ->create()
            ->each(
                function($admin) {
                    $admin->assignRole('web-admin');
                }
            );

            Admin::factory()->count(1)
            ->create()
            ->each(
                function($admin) {
                    $admin->assignRole('web-user');
                }
            );
    }
}
