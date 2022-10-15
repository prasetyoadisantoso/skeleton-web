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

            // Administrator Permissions
            [
                'id' => '1',
                'name' => 'dashboard',
                'guard_name' => 'web'
            ],
            [
                'id' => '2',
                'name' => 'user-index',
                'guard_name' => 'web'
            ],
            [
                'id' => '3',
                'name' => 'user-create',
                'guard_name' => 'web'
            ],
            [
                'id' => '4',
                'name' => 'user-store',
                'guard_name' => 'web'
            ],
            [
                'id' => '5',
                'name' => 'user-show',
                'guard_name' => 'web'
            ],
            [
                'id' => '6',
                'name' => 'user-edit',
                'guard_name' => 'web'
            ],
            [
                'id' => '7',
                'name' => 'user-update',
                'guard_name' => 'web'
            ],
            [
                'id' => '8',
                'name' => 'user-delete',
                'guard_name' => 'web'
            ],

        ]);
    }
}
