<?php

namespace App\Providers;

use App\Services\GlobalVariable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Artisan command to make view
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Sven\ArtisanView\ServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Set Url HTTP or HTTPS */
        URL::forceScheme(env('URL_SCHEME'));
        /* End */

        /* IP record to activity Log */
        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('ip', $this->get_client_ip());
        });
        /* End */

        /**
         * Add global variable for rendering to template
         * Data must be from static function
         */
        try {
            $data = [

                // Static code here
                GlobalVariable::SitesLogo(),
                GlobalVariable::SitesFavicon(),

            ];
            foreach ($data as  $render) {
                view()->share($render);
            }
        } catch (\Throwable $th) {
            // Let fresh migration executed
        }
        /* End */

    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

}
