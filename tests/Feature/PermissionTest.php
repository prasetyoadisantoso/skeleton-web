<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIndexPermissionsPage()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->get(route('permission.index'), [
            Auth::attempt($user)
        ])->assertStatus(200);

    }

    public function testPermissionsDatatable()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->get(route('permission.datatable'), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testCreatePermissionPage()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->get(route('permission.create'), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testStorePermission()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->postJson(route('permission.store'), [
            'name' => 'sample index'
        ], [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testEditPermissionPage()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->getJson(route('permission.edit', 9), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testUpdatePermission()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->putJson(route('permission.update', 9), [
            'name' => 'sample show'
        ], [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testDeletePermission()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->deleteJson(route('permission.destroy', 9), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }
}
