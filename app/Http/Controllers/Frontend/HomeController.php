<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\GlobalView;
use App\Services\GlobalVariable;
use App\Services\Translations;
use App\Services\SEO;

class HomeController extends Controller
{
    protected $global_view, $global_variable, $translation, $seo;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        SEO $seo,
    )
    {
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->seo = $seo;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),
            $this->global_variable->SiteFavicon(),
            $this->global_variable->PageType('home'),

            // SEO
            $this->global_variable->GoogleTagId(),
            $this->global_variable->SocialMedia(),

            // Translations
            $this->translation->home,

            // SEO
            $this->seo->MetaHome(),
            $this->seo->OpengraphHome(),
            $this->seo->CanonicalHome(),

        ]);
    }

    public function index()
    {
        $this->boot();
        return view('template.default.frontend.page.home');
    }

}
