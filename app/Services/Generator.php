<?php

namespace App\Services;

use App\Services\FileManagement;
use App\Services\Upload;
use Faker\Factory;

class Generator
{
    // Generate Fake User
    public function GenerateFakeUser()
    {

        $upload = new Upload;
        $fileManagement = new FileManagement;

        $faker = Factory::create('en_US');
        $image = $upload->UploadImageUserToStorage($fileManagement->GetPathProfileImage());
        $new_client = [
            'name' => $faker->name(),
            'email' => $faker->email(),
            'image' => $image,
            'phone' => "081234567890",
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        return $new_client;
    }
}
