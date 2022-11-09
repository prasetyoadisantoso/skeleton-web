<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleTest extends TestCase
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

    public function testIndexRolePage()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->get(route('role.index'), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testRoleDatatable()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];
        $this->get(route('role.datatable'), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testCreateRolePage()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];

        $this->get(route('role.create'), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testStoreRole()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];

        $name = 'Editor';
        $permissions = [
            'user-edit', 'user-show', 'user-index', 'sample index'
        ];

        $this->postJson(route('role.store'), [
            'name' => $name,
            'permissions' => $permissions
        ], [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testEditRolePage()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];

        $this->get(route('role.edit', 4), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testUpdateRole()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];

        $name = 'editor';
        $permissions = [
            'user-edit', 'user-show'
        ];

        $this->putJson(route('role.update', 4), [
            'name' => $name,
            'permissions' => $permissions
        ], [
            Auth::attempt($user)
        ])->assertStatus(200);
    }

    public function testDeleteRole()
    {
        $user = [
            'email' => 'admin@email.com',
            'password' => '123456',
        ];

        $this->deleteJson(route('role.destroy', 4), [
            Auth::attempt($user)
        ])->assertStatus(200);
    }
}
