<?php

namespace Tests\Feature;

use App\Models\Meta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Tests\TestCase;

class MetaTest extends TestCase
{
    public function user_auth()
    {
        return Auth::attempt(['email' => 'admin@email.com', 'password' => '123456']);
    }

    public function locale()
    {
        return LaravelLocalization::setLocale('en');
    }

    public function test_meta_index_page()
    {
        $this->getJson(route('meta.index'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_index_datatable()
    {
        $this->getJson(route('meta.datatable'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_create_page()
    {
        $this->getJson(route('meta.create'), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_store()
    {
        $this->postJson(route('meta.store'),[
            'name' => 'Home',
            'robot' => 'noindex, nofollow',
            'description' => 'Ini adalah meta deskripsi',
            'keyword' => 'Ini adalah meta keyword',
        ], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_show()
    {
        $metadata = new Meta;
        $data = $metadata->query()->first();
        $this->getJson(route('meta.show', $data->id), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_edit()
    {
        $metadata = new Meta;
        $data = $metadata->query()->first();
        $this->getJson(route('meta.edit', $data->id), [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_update()
    {
        $metadata = new Meta;
        $data = $metadata->query()->first();
        $this->putJson(route('meta.update', $data->id),[
            'name' => $data->name,
            'robot' => $data->robot,
            'description' => 'This is meta description',
            'keyword' => 'This is meta keyword',
        ], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }

    public function test_meta_delete()
    {
        $metadata = new Meta;
        $data = $metadata->query()->first();
        $this->deleteJson(route('meta.destroy', $data->id), [], [
            $this->user_auth(),
            $this->locale()
        ])->assertStatus(200);
    }
}
