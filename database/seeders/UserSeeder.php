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

        $imageSuperadmin = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('superadmin')) ;
        $imageAdmin = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('admin')) ;
        $imageCustomer = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('customer')) ;
        $imageEditor = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('editor')) ;
        $imageGuest = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage('guest')) ;


        DB::table('users')->insert([

            // Super Admin User

            [
                'id' => '4f10db02-2ff7-403a-8945-f2cc2348fa06',
                'name' => 'Super Administrator',
                'image' => $imageSuperadmin,
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

            // Editor User
            [
                'id' => '4c956744-83d4-4d49-b604-bc2cf107ed51',
                'name' => 'Best Editor',
                'image' => $imageEditor,
                'email' => 'editor@email.com',
                'password' => Hash::make("123456"),
                'phone' => "089876543210",
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

            // Customer User
            [
                'id' => 'b11833ee-2d65-400e-97f1-a47647326ac2',
                'name' => 'Best Customer',
                'image' => $imageCustomer,
                'email' => 'customer@email.com',
                'password' => Hash::make("123456"),
                'phone' => "089876543210",
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

            // Guest User
            [
                'id' => '67ea7b54-fb0e-45f5-99c6-8471e24745ac',
                'name' => 'Ordinary Guest',
                'image' => $imageGuest,
                'email' => 'guest@email.com',
                'password' => Hash::make("123456"),
                'phone' => "089876543210",
                'email_verified_at' => date("Y-m-d H:i:s"),
            ],

        ]);
    }
}
