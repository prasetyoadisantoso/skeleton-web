<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\FrontendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\SEO;

class HomeController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $seo;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        SEO $seo,
    ) {
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->seo = $seo;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->PageType('home'),
            $this->global_variable->SitesLogo(),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.frontend.development.index');
    }
}
