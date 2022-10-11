<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestRegisterFormRequest;
use App\Models\User;
use App\Services\FileManagement;
use App\Services\ResponseFormatter;
use Illuminate\Http\Request;

class TestAuthController extends Controller
{
    public function index(
        FileManagement $filemanagement,
        ResponseFormatter $response) {
        $filemanagement->Logging($response->successResponse([
            "Full Name" => "Insert full name",
            "Email" => "Insert email address",
            "Password" => "Insert password",
            "Password Confirmation" => "Insert password confirmation",
        ]));
    }

    public function register(
        TestRegisterFormRequest $testRegister,
        User $user,
        $type
    ) {
        $testRegister->validated();
        $client = $testRegister->only(["name", "email", "image", "phone", "password", "password_confirmation"]);
        switch ($type) {
            case 'client':
                // Store user to database
                $user->StoreUser($client);

                // Generate token


                break;

            default:
                return redirect()->route('test.home', '', 302);
                break;
        }
    }
}
