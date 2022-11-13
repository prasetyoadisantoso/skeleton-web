<?php

namespace Tests\Feature;

use App\Models\General;
use App\Services\FileManagement;
use App\Services\Upload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Tests\TestCase;

class GeneralTest extends TestCase
{

    public function test_index_site()
    {
        LaravelLocalization::setLocale('id');
        $this->get(route('general.index.test'))->assertStatus(200);
    }

    public function test_update_site_description_en()
    {
        $data = General::first();
        $this->postJson(route('general.update.description.test'), [
            'id' => $data['id'],
            'site_title' => $data['site_title'],
            'site_tagline' => "Build web app",
            'url_address' => "https://127.0.0.1:8000",
            'copyright' => '&copy; 2022 - Skeleton Web',
            'cookies_concern' => "Lorem ipsum in english language"
        ], [
            LaravelLocalization::setLocale('en')
        ])->assertStatus(200);
    }

    public function test_update_site_description_id()
    {
        $data = General::first();
        $this->postJson(route('general.update.description.test'), [
            'id' => $data['id'],
            'site_title' => $data['site_title'],
            'site_tagline' => "Membuat web app",
            'url_address' => "https://127.0.0.1:8000",
            'copyright' => '&copy; 2022 - Skeleton Web',
            'cookies_concern' => "Lorem ipsum dalam bahasa indonesia"
        ], [
            LaravelLocalization::setLocale('id')
        ])->assertStatus(200);
    }

    public function test_update_site_logo_favicon()
    {
        $upload = new Upload;
        $fileManagement = new FileManagement;
        $site_logo = $upload->UploadImageLogoToStorage($fileManagement->GetPathLogoImage());
        $site_favicon = $upload->UploadImageFaviconToStorage($fileManagement->GetPathFaviconImage());
        $data = General::first();
        $this->postJson(route('general.update.logo.favicon.test'), [
            'id' => $data['id'],
            'site_logo' => $site_logo,
            'site_favicon' => $site_favicon,
        ], [
            // LaravelLocalization::setLocale('id')
        ])->assertStatus(200);
    }
}
