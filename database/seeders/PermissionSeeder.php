<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([

            // User Permissions
            [
                'id' => '1',
                'name' => 'user-index',
                'guard_name' => 'web'
            ],
            [
                'id' => '2',
                'name' => 'user-create',
                'guard_name' => 'web'
            ],
            [
                'id' => '3',
                'name' => 'user-store',
                'guard_name' => 'web'
            ],
            [
                'id' => '4',
                'name' => 'user-show',
                'guard_name' => 'web'
            ],
            [
                'id' => '5',
                'name' => 'user-edit',
                'guard_name' => 'web'
            ],
            [
                'id' => '6',
                'name' => 'user-update',
                'guard_name' => 'web'
            ],
            [
                'id' => '7',
                'name' => 'user-destroy',
                'guard_name' => 'web'
            ],

            // Role Permissions
            [
                'id' => '8',
                'name' => 'role-index',
                'guard_name' => 'web'
            ],
            [
                'id' => '9',
                'name' => 'role-create',
                'guard_name' => 'web'
            ],
            [
                'id' => '10',
                'name' => 'role-store',
                'guard_name' => 'web'
            ],
            [
                'id' => '11',
                'name' => 'role-show',
                'guard_name' => 'web'
            ],
            [
                'id' => '12',
                'name' => 'role-edit',
                'guard_name' => 'web'
            ],
            [
                'id' => '13',
                'name' => 'role-update',
                'guard_name' => 'web'
            ],
            [
                'id' => '14',
                'name' => 'role-destroy',
                'guard_name' => 'web'
            ],

            // Permission of permissions
            [
                'id' => '15',
                'name' => 'permission-index',
                'guard_name' => 'web'
            ],
            [
                'id' => '16',
                'name' => 'permission-create',
                'guard_name' => 'web'
            ],
            [
                'id' => '17',
                'name' => 'permission-store',
                'guard_name' => 'web'
            ],
            [
                'id' => '18',
                'name' => 'permission-show',
                'guard_name' => 'web'
            ],
            [
                'id' => '19',
                'name' => 'permission-edit',
                'guard_name' => 'web'
            ],
            [
                'id' => '20',
                'name' => 'permission-update',
                'guard_name' => 'web'
            ],
            [
                'id' => '21',
                'name' => 'permission-destroy',
                'guard_name' => 'web'
            ],

            // General Permissions
            [
                'id' => '22',
                'name' => 'general-index',
                'guard_name' => 'web'
            ],
            [
                'id' => '23',
                'name' => 'general-update',
                'guard_name' => 'web'
            ],

        ]);
    }
}
