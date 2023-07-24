<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\Upload;
use App\Services\FileManagement;

class OpengraphSeeder extends Seeder
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

        $opengraphimage = $upload->UploadOpengraphImageToStorage($fileManagement->GetPathFeatureImage());

        DB::table('opengraphs')->insert([
            [
                'id' => 'e8edd87f-3b67-4191-98ba-c0455f9c7705',
                "name" => "Home",
                "title" => "Website Name",
                "url" => "https://example.com",
                "site_name" => "Website Name",
                'image' => $opengraphimage,
                "description" => '{"en":"website description","id":"deskripsi website"}',
                "type" => "website",
            ],

            [
                'id' => '53708182-01c8-4b0d-b39d-0494873b2e99',
                "name" => "Article",
                "title" => "Article Name",
                "url" => "https://example.com",
                "site_name" => "Article Name",
                'image' => $opengraphimage,
                "description" => '{"en":"website description","id":"deskripsi website"}',
                "type" => "website",
            ],

            [
                'id' => '5a765094-a557-4f46-afa0-09ef37ca0b47',
                "name" => "Contact",
                "title" => "Contact",
                "url" => "https://example.com",
                "site_name" => "Contact",
                'image' => $opengraphimage,
                "description" => '{"en":"website description","id":"deskripsi website"}',
                "type" => "website",
            ],
        ]);
    }
}
