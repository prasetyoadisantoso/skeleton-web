<?php

namespace App\Services;

use App\Models\General;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Message;

class GlobalVariable
{
    protected $general;
    public function __construct(General $general)
    {
        $this->general = $general;
    }

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
        $data = $this->general->query()->first()->only(['site_logo']);
        return [
            'site_logo' => Storage::url($data['site_logo'])
        ];
    }

    public function SiteFavicon()
    {
        $data = $this->general->query()->first()->only(['site_favicon']);
        return [
            'site_favicon' => Storage::url($data['site_favicon'])
        ];
    }

    public static function SitesLogo()
    {
        $general = new General;
        $data = $general->query()->first()->only(['site_logo']);
        return [
            'site_logo' => Storage::url($data['site_logo'])
        ];
    }

    public static function SitesFavicon()
    {
        $general = new General;
        $data = $general->query()->first()->only(['site_favicon']);
        return [
            'site_favicon' => Storage::url($data['site_favicon'])
        ];
    }

    public function PageType(string $type): ?array
    {
        return [
            'type' => $type
        ];
    }

    public function ModuleType(array $type): ?array
    {
        return [
            'module' => $type
        ];
    }

    public function ScriptType(array $type): ?array
    {
        return [
            'script' => $type
        ];
    }

    public function RouteType(string $type): ?array
    {
        return [
            'url' => $type
        ];
    }

    public function MessageNotification(){
        $message = Message::select('name', 'read_at')->whereNull('read_at')->get();
        $message_count = Message::whereNull('read_at')->count();
        return [
          'message_notification' => $message,
          'message_notification_count' => $message_count
        ];
    }
}
