<?php

namespace App\Http\Controllers;

use App\Services\FileManagement;
use App\Services\ResponseFormatter;

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

    public function register($type)
    {

    }
}
