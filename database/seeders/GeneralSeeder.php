<?php

namespace Database\Seeders;

use App\Models\General;
use App\Models\MediaLibrary;
use App\Services\FileManagement;
use App\Services\Upload;
use Illuminate\Database\Seeder;
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
        // Initialize services
        $fileManagement = new FileManagement();
        $upload = new Upload();

        // Create a default General record
        $general = General::create([
            'id' => (string) Uuid::generate(4),
            'site_title' => 'Skeleton Web',
            'site_tagline' => 'dummy',
            'site_email' => 'info@example.com',
            'url_address' => 'https://example.com',
            'copyright' => 'dummy',
            'google_tag' => '12345678',
            'cookies_concern' => 'dummy',
        ]);

        // Set translatable attributes
        $general->setTranslations('site_tagline', [
            'en' => 'Build your website as you want',
            'id' => 'Buat website sesuka hati anda',
        ]);

        $general->setTranslations('copyright', [
            'en' => '© 2022 - Copyright Skeleton Web',
            'id' => '© 2022 - Hak Cipta Skeleton Web',
        ]);

        $general->setTranslations('cookies_concern', [
            'en' => 'Lorem ipsum in english',
            'id' => 'Lorem ipsum dalam bahasa Indonesia',
        ]);

        $general->save();

        // Upload logo and favicon
        $logoFile = $fileManagement->GetPathLogoImage();
        $faviconFile = $fileManagement->GetPathFaviconImage();

        $logoData = $upload->UploadImageLogoToMediaLibrary($logoFile);
        $faviconData = $upload->UploadImageFaviconToMediaLibrary($faviconFile);

        // Create MediaLibrary records for logo and favicon
        $logoMedia = MediaLibrary::create([
            'title' => pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME),
            'media_files' => $logoData['media_path'],
            'information' => '',
            'description' => '',
        ]);

        $faviconMedia = MediaLibrary::create([
            'title' => pathinfo($faviconFile->getClientOriginalName(), PATHINFO_FILENAME),
            'media_files' => $faviconData['media_path'],
            'information' => '',
            'description' => '',
        ]);

        // Update the General record with the MediaLibrary IDs
        $general->site_logo_id = $logoMedia->id;
        $general->site_favicon_id = $faviconMedia->id;
        $general->save();
    }
}
