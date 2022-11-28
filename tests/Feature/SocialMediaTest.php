<?php

namespace Tests\Feature;

use App\Models\SocialMedia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SocialMediaTest extends TestCase
{
    public function user_auth()
    {
        return Auth::attempt(['email' => 'superadmin@email.com', 'password' => '123456']);
    }

    public function locale($locale)
    {
        return LaravelLocalization::setLocale($locale);
    }

    public function test_index_social_media()
    {
        $this->getJson(route('social_media.index'), [
            $this->user_auth(),
            $this->locale('id')
        ])->assertStatus(200);
    }

    public function test_store_social_media()
    {
        $this->postJson(route('social_media.store'), [
            'name' => 'Instagram',
            'url' => 'https://instagram.com/username'
        ], [
            $this->user_auth()
        ])->assertStatus(200);
    }

    public function test_edit_social_media()
    {
        $sm = SocialMedia::first();
        $this->getJson(route('social_media.edit', $sm->id), [
            $this->user_auth()
        ])->assertStatus(200);
    }

    public function test_update_social_media()
    {
        $sm = SocialMedia::first();
        $this->putJson(route('social_media.update', $sm->id),[
            'name' => 'Facebook Social',
            'url' => 'https://example.com'
        ], [
            $this->user_auth()
        ])->assertStatus(200);
    }

    public function test_delete_social_media()
    {
        $sm = SocialMedia::first();
        $this->deleteJson(route('social_media.destroy', $sm->id),[
            $this->user_auth()
        ])->assertStatus(200);
    }
}
