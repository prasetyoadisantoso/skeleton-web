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

            // Administrator
            [
                'id' => "1",
                'name' => 'administrator',
                'guard_name' => 'web'
            ],

            // Client
            [
                'id' => '2',
                'name' => 'client',
                'guard_name' => 'web'
            ]

        ]);
    }
}
