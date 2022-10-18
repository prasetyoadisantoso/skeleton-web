<?php

namespace Tests\Feature;

use App\Models\Token;
use App\Models\User;
use App\Services\Encryption;
use App\Services\Generator;
use Tests\TestCase;

class B_AuthTest extends TestCase
{
    public function testAccessLoginPage()
    {
        $this->getJson(route('test.login.home'))->assertStatus(200);
    }

    public function testAccessRegisterPage()
    {
        $this->getJson(route('test.register.home'))->assertStatus(200);
    }

    public function testRegisterClient()
    {
        $generator = new Generator();
        $this->postJson(route('test.client.register', "client"), $generator->GenerateFakeUser())->assertStatus(200);
    }

    public function testRegisterNotClient()
    {
        $generator = new Generator();
        $this->postJson(route('test.client.register', "administrator"), $generator->GenerateFakeUser())->assertStatus(302);
    }

    public function testVerifyClient()
    {
        $encryption = new Encryption;
        $dataToken = Token::inRandomOrder()->first();
        $encryptedToken = $encryption->EncryptToken($dataToken->token);
        $trueToken = $encryptedToken;
        $falseToken = "123456";
        $this->postJson(route('test.client.verify', [
            "token" => $trueToken,
        ]))->assertStatus(200);
    }

    public function testResendVerification()
    {
        $not_verified_user = User::inRandomOrder()->where('email_verified_at', '=', null)->first();
        $this->postJson(route('test.client.resend', [
            "email" => $not_verified_user->email,
        ]))->assertStatus(200);
    }

    public function testResetPasswordPage()
    {
        $this->getJson(route('test.reset.home'))->assertStatus(200);
    }

    public function testResendResetPassword()
    {
        $reset_password_user = User::inRandomOrder()->first();
        $this->postJson(route('test.client.resend.reset'), [
            "email" => $reset_password_user->email,
        ])->assertStatus(200);
    }

    public function testCheckResetPassword()
    {
        $encryption = new Encryption;
        $dataToken = Token::inRandomOrder()->first();
        $encryptedToken = $encryption->EncryptToken($dataToken->token);
        $trueToken = $encryptedToken;
        $falseToken = "123456";
        $this->postJson(route('test.client.check.reset', [
            "token" => $trueToken,
        ]))->assertStatus(200);
    }

    public function testRedirectToResetPasswordForm()
    {
        $encryption = new Encryption;
        $dataToken = Token::inRandomOrder()->first();
        $encryptedToken = $encryption->EncryptToken($dataToken->token);
        $trueToken = $encryptedToken;
        $falseToken = "123456";

        $this->getJson(route('test.reset.form'), [
            "token" => $trueToken
        ])->assertStatus(200);
    }

    public function testResetPassword()
    {
        $encryption = new Encryption;
        $dataToken = Token::inRandomOrder()->first();
        $encryptedToken = $encryption->EncryptToken($dataToken->token);
        $old_password = "123456";
        $new_password = "654321";
        $confirm_new_password = "654321";

        $this->postJson(route('test.client.reset'), [
            "token" => $encryptedToken,
            "old_password" => $old_password,
            "password" => $new_password,
            "password_confirmation" => $confirm_new_password
        ])->assertStatus(200);
    }

}
