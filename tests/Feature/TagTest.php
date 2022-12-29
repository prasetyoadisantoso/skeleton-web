<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagTest extends TestCase
{
    public function user_auth()
    {
        return Auth::attempt(['email' => 'superadmin@email.com', 'password' => '123456']);
    }

    public function locale()
    {
        return LaravelLocalization::setLocale('en');
    }

    public function test_tag_index_page()
    {
        $this->getJson(route('tag.index'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_tag_index_datatable()
    {
        $this->getJson(route('tag.datatable'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_tag_create_page()
    {
        $this->getJson(route('tag.create'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_tag_store()
    {
        $this->postJson(route('tag.store'),[
            'name' => 'update news',
            'slug' => 'update news'
        ], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_tag_edit()
    {
        $tagdata = new Tag;
        $data = $tagdata->query()->first();
        $this->getJson(route('tag.edit', $data->id), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_tag_update()
    {
        $tagdata = new Tag;
        $data = $tagdata->query()->first();
        $this->putJson(route('tag.update', $data->id),[
            'name' => 'good news',
            'slug' => '',
        ], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_tag_delete()
    {
        $tagdata = new Tag;
        $data = $tagdata->query()->first();
        $this->deleteJson(route('tag.destroy', $data->id), [], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }
}
