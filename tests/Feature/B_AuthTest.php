<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

}
