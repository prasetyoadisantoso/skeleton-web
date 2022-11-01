<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlobalVariable
{
    public function TitlePage(string $title_name): ?array
    {
        return [
            'title' => $title_name
        ];
    }

    public function SystemLanguage()
    {
        return [
            'current_locale' => LaravelLocalization::getCurrentLocale()
        ];
    }

    public function SystemName()
    {
        return [
            'system_name' => config('app.name')
        ];
    }

    public function AuthUserName()
    {
        return [
            'name' => Auth::user()->only(['name'])['name']
        ];
    }

    public function SiteLogo()
    {
        return [
            'site_logo' => "https://laravel.com/img/logomark.min.svg"
        ];
    }
}
