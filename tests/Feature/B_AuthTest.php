<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\Generator;

class B_AuthTest extends TestCase
{

    public function testAccessRegisterPage()
    {
        $this->getJson(route('test.register.home'))->assertStatus(200);
    }

    public function testRegisterPage()
    {
        $this->getJson(route('test.client.register'))->assertStatus(200);
    }

    public function testRegisterClient()
    {
        $generator = new Generator();
        $this->postJson(route('test.client.register', "client"), $generator->GenerateFakeUser())->assertStatus(302);
    }

    public function testRegisterNotClient(Type $var = null)
    {
        $generator = new Generator();
        $this->postJson(route('test.client.register', "administrator"), $generator->GenerateFakeUser())->assertStatus(302);
    }

}
