<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class GlobalVariable
{
    public function SystemName()
    {
        return config('app.name');
    }

    public function AuthUser()
    {
        return Auth::user();
    }

    public function SiteLogo()
    {
        return "https://laravel.com/img/logomark.min.svg";
    }
}
