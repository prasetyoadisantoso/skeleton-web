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

            // Super Admin Role
            [
                'role_id' => '1',
                'model_type' => 'App\Models\User',

                // Username : Super Administrator
                'model_id' => '4f10db02-2ff7-403a-8945-f2cc2348fa06'
            ],

            // Administrator Role
            [
                'role_id' => '2',
                'model_type' => 'App\Models\User',

                // Username : Administrator Department
                'model_id' => 'c41833ee-2d65-400e-97f1-a47647326ab4'
            ],

            // Editor Role
            [
                'role_id' => '3',
                'model_type' => 'App\Models\User',

                // Username : Best Editor
                'model_id' => '4c956744-83d4-4d49-b604-bc2cf107ed51'
            ],

            // Customer Role
            [
                'role_id' => '4',
                'model_type' => 'App\Models\User',

                // Username : Best Customer
                'model_id' => 'b11833ee-2d65-400e-97f1-a47647326ac2'
            ],

            // Guest Role
            [
                'role_id' => '5',
                'model_type' => 'App\Models\User',

                // Username : Best Editor
                'model_id' => '67ea7b54-fb0e-45f5-99c6-8471e24745ac'
            ],

        ]);
    }
}
