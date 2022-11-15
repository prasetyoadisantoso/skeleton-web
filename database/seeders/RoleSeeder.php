<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([

            // Super Administrator
            [
                'id' => "1",
                'name' => 'superadmin',
                'guard_name' => 'web'
            ],

            // Administrator
            [
                'id' => '2',
                'name' => 'administrator',
                'guard_name' => 'web'
            ],

            // Customer
            [
                'id' => '3',
                'name' => 'customer',
                'guard_name' => 'web'
            ],

            // Guest
            [
                'id' => '4',
                'name' => 'guest',
                'guard_name' => 'web'
            ],



            // Editor
            [
                'id' => '5',
                'name' => 'editor',
                'guard_name' => 'web'
            ],

        ]);
    }
}
