<?php

namespace Database\Seeders;

use App\Services\FileManagement;
use App\Services\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class GeneralSeeder extends Seeder
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

        $imageLogo = $upload->UploadImageLogoToStorage($fileManagement->GetPathLogoImage());
        $imageFavicon = $upload->UploadImageFaviconToStorage($fileManagement->GetPathFaviconImage());

        DB::table('generals')->insert([
            'id' => (string)Uuid::generate(4),
            'site_title' => 'Skeleton Web',
            'site_tagline' => '{"en":"Build your website as you want","id":"Buat website sesuka hati anda"}',
            'site_logo' => $imageLogo,
            'site_favicon' => $imageFavicon,
            'url_address' => 'https://localhost:8000',
            'copyright' => '&copy; 2022 - Skeleton Web',
            'cookies_concern' => '{"en":"Lorem ipsum in english","id":"Lorem ipsum dalam bahasa Indonesia"}'
        ]);

    }

}
