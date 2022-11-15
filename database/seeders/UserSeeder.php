<?php

namespace Database\Seeders;

use App\Services\FileManagement;
use App\Services\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileManagement = new FileManagement;
        $upload = new Upload;

        $imageAdmin = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('admin')) ;
        $imageClient = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('client')) ;


        DB::table('users')->insert([

            // Super Admin User

            [
                'id' => '4f10db02-2ff7-403a-8945-f2cc2348fa06',
                'name' => 'Super Administrator',
                'image' => $imageAdmin,
                'email' => 'superadmin@email.com',
                'password' => Hash::make("123456"),
                'phone' => "081234567890",
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

            // Administrator User
            [
                'id' => 'c41833ee-2d65-400e-97f1-a47647326ab4',
                'name' => 'Administrator Department',
                'image' => $imageAdmin,
                'email' => 'admin@email.com',
                'password' => Hash::make("123456"),
                'phone' => "081234567890",
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

            // Customer User
            [
                'id' => 'b11833ee-2d65-400e-97f1-a47647326ac2',
                'name' => 'Best Customer',
                'image' => $imageClient,
                'email' => 'customer@email.com',
                'password' => Hash::make("123456"),
                'phone' => "089876543210",
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

        ]);
    }
}
