<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->insert([

            /**
             * Administrator permission list
             **/
            [
                'role_id' => "1",
                // Permission Dashboard
                'permission_id' => '1'
            ],
            [
                'role_id' => "1",
                // Permission User Index
                'permission_id' => '2'
            ],
            [
                'role_id' => "1",
                // Permission User Create
                'permission_id' => '3'
            ],
            [
                'role_id' => "1",
                // Permission User Store
                'permission_id' => '4'
            ],
            [
                'role_id' => "1",
                // Permission User Show
                'permission_id' => '5'
            ],
            [
                'role_id' => "1",
                // Permission User Edit
                'permission_id' => '6'
            ],
            [
                'role_id' => "1",
                // Permission User Update
                'permission_id' => '7'
            ],
            [
                'role_id' => "1",
                // Permission User Delete
                'permission_id' => '8'
            ],

            /**
             * Administrator permission list
             **/
            [
                'role_id' => "2",
                // Permission User Delete
                'permission_id' => '1'
            ],

        ]);
    }
}
