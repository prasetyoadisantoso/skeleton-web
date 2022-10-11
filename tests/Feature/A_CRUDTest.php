<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Generator;
use Tests\TestCase;

class A_CRUDTest extends TestCase
{
    public function testAccessHomePage()
    {
        $this->getJson(route('test.home'))->assertStatus(200);
    }

    public function testAccessCreatePage()
    {
        $this->getJson(route('test.create'))->assertStatus(200);
    }

    public function testStoreUser()
    {
        $generator = new Generator();
        $this->postJson(route('test.store'), $generator->GenerateFakeUser())->assertStatus(200);
    }

    public function testGetDetailUser()
    {
        $get_user = User::inRandomOrder()->first();
        $this->getJson(route('test.show', $get_user->id))->assertStatus(200);
    }

    public function testAccessEditUserPage()
    {
        $get_user = User::inRandomOrder()->first();
        $this->getJson(route('test.edit', $get_user->id))->assertStatus(200);
    }

    public function testUpdateDataUser()
    {
        $get_user_id = User::inRandomOrder()->first('id')->id;

        $generator = new Generator();
        $new_data = $generator->GenerateFakeUser();

        $this->putJson(route('test.update', $get_user_id),
  [
            'name' => $new_data['name'],
            'email' => $new_data['email'],
            'image' => $new_data['image'],
            'password' => '',
            'password_confirmation' => '',
        ]
        )->assertStatus(200);
    }

    public function testDeleteUser()
    {
        $get_user_id = User::inRandomOrder()->first('id')->id;
        $this->deleteJson(route('test.delete', $get_user_id))->assertStatus(200);
    }
}
