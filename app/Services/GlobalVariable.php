<?php

namespace App\Services;

use App\Models\General;
use App\Models\Message;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlobalVariable
{
    protected $general, $socialMedia;
    public function __construct(
        General $general,
        SocialMedia $socialMedia,
    ) {
        $this->general = $general;
        $this->socialMedia = $socialMedia;
    }

    public function TitlePage(string $title_name):  ? array
    {
        return [
            'title' => $title_name,
        ];
    }

    public function SystemLanguage()
    {
        return [
            'current_locale' => LaravelLocalization::getCurrentLocale(),
        ];
    }

    public function SystemName()
    {
        return [
            'system_name' => config('app.name'),
        ];
    }

    public function AuthUserName()
    {
        return [
            'name' => Auth::user()->only(['name'])['name'],
        ];
    }

    public function SiteLogo()
    {
        $data = $this->general->query()->first()->only(['site_logo']);
        return [
            'site_logo' => Storage::url($data['site_logo']),
        ];
    }

    public function SiteFavicon()
    {
        $data = $this->general->query()->first()->only(['site_favicon']);
        return [
            'site_favicon' => Storage::url($data['site_favicon']),
        ];
    }

    public static function SitesLogo()
    {
        $general = new General;
        $data = $general->query()->first()->only(['site_logo']);
        return [
            'site_logo' => Storage::url($data['site_logo']),
        ];
    }

    public static function SitesFavicon()
    {
        $general = new General;
        $data = $general->query()->first()->only(['site_favicon']);
        return [
            'site_favicon' => Storage::url($data['site_favicon']),
        ];
    }

    public function SiteEmail()
    {
        $data = $this->general->first()->only(['site_email']);
        return [
            'site_email' => $data['site_email'],
        ];
    }

    public function PageType(string $type) :  ? array
    {
        return [
            'type' => $type,
        ];
    }

    public function ModuleType(array $type) :  ? array
    {
        return [
            'module' => $type,
        ];
    }

    public function ScriptType(array $type) :  ? array
    {
        return [
            'script' => $type,
        ];
    }

    public function RouteType(string $type) :  ? array
    {
        return [
            'url' => $type,
        ];
    }

    public function SocialMedia()
    {
        return [
            'social_media' => $this->socialMedia->where('name', 'Instagram')->orWhere('name', 'Github')->orWhere('name', 'Gitlab')->get()->toArray()
        ];
    }

    public function GoogleTagId() {
        return [
            'google_tag' => $this->general->query()->first()->only(['google_tag'])
        ];
    }

    public function MessageNotification()
    {
        $message = Message::select('name', 'read_at')->whereNull('read_at')->get();
        $message_count = Message::whereNull('read_at')->count();
        return [
            'message_notification' => $message,
            'message_notification_count' => $message_count,
        ];
    }
}
