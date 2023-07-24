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
                "title" => "Skeleton Web",
                "url" => "https://skeleton-web.prasetyoadisantoso.com",
                "site_name" => "Website Name",
                'image' => $opengraphimage,
                "description" => '{"en":"Kerangka web yang ringan dan mudah digunakan yang dapat digunakan untuk membuat berbagai jenis situs web.","id":"a lightweight and easy-to-use web framework that can be used to create various types of websites."}',
                "type" => "website",
            ],

            [
                'id' => '53708182-01c8-4b0d-b39d-0494873b2e99',
                "name" => "Blog",
                "title" => "Skeleton Web - Blog",
                "url" => "https://skeleton-web.prasetyoadisantoso.com/blog",
                "site_name" => "Skeleton Web",
                'image' => $opengraphimage,
                "description" => '{"en":"Sample blog for Skeleton Web","id":"Contoh blog dari Skeleton Web"}',
                "type" => "website",
            ],

            [
                'id' => '5a765094-a557-4f46-afa0-09ef37ca0b47',
                "name" => "Contact",
                "title" => "Contact",
                "url" => "https://example.com",
                "site_name" => "Contact",
                'image' => $opengraphimage,
                "description" => '{"en":"Sample contact message for Skeleton Web","id":"Contoh pesan kontak dari skeleton web"}',
                "type" => "website",
            ],
        ]);
    }
}
