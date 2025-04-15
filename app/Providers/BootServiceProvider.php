<?php

namespace App\Providers;

use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class BootServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->URLScheme();
        $this->BackendGlobalVariable();
        $this->IPLogs();
        $this->HeaderBackendTranslations();
        $this->SidebarBackendTranslations();
        $this->ButtonBackendTranslations();
        $this->NotificationBackendTranslations();
    }

    public function NotificationBackendTranslations()
    {
        $translation = new BackendTranslations();

        return view()->share($translation->notification);
    }

    public function HeaderBackendTranslations()
    {
        $translation = new BackendTranslations();

        return view()->share($translation->header);
    }

    public function SidebarBackendTranslations()
    {
        $translation = new BackendTranslations();

        return view()->share($translation->sidebar);
    }

    public function ButtonBackendTranslations()
    {
        $translation = new BackendTranslations();

        return view()->share($translation->button);
    }

    public function URLScheme()
    {
        return URL::forceScheme(env('URL_SCHEME'));
    }

    public function IPLogs()
    {
        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('ip', $this->get_client_ip());
        });
    }

    public function BackendGlobalVariable()
    {
        try {
            view()->share(GlobalVariable::SitesLogo());
            view()->share(GlobalVariable::SitesFavicon());
        } catch (\Throwable $th) {
            return redirect(url('/'));
        }
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
}
