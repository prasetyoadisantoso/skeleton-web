<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_roles')->insert([

            // Administrator to Role
            [
                'role_id' => '1',
                'model_type' => 'App\Model\User',

                // Administrator Department
                'model_id' => 'c41833ee-2d65-400e-97f1-a47647326ab4'
            ],

            // Client to Role
            [
                'role_id' => '2',
                'model_type' => 'App\Model\User',

                // Best Client
                'model_id' => 'b11833ee-2d65-400e-97f1-a47647326ac2'
            ],

        ]);
    }
}
