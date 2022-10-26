<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlobalVariable
{
    public function GlobalAdmin($module_name)
    {
        View::share('title', $module_name);
    }

    public function GlobalLanguage()
    {
        View::share('current_locale', LaravelLocalization::getCurrentLocale());
    }

    public function SystemName()
    {
        return [
            'system_name' => config('app.name')
        ];
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
