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
            ],
            [
                'id' => '2',
                'name' => 'user-index',
            ],
            [
                'id' => '3',
                'name' => 'user-create',
            ],
            [
                'id' => '4',
                'name' => 'user-store',
            ],
            [
                'id' => '5',
                'name' => 'user-show',
            ],
            [
                'id' => '6',
                'name' => 'user-edit',
            ],
            [
                'id' => '7',
                'name' => 'user-update',
            ],
            [
                'id' => '8',
                'name' => 'user-delete',
            ],

        ]);
    }
}
