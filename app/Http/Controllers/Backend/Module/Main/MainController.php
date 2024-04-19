<?php

namespace App\Http\Controllers\Backend\Module\Main;

use App\Http\Controllers\Controller;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\BackendTranslations;

class MainController extends Controller
{
    protected $global_variable, $global_view, $translation, $backend_translation;

    public function __construct(
        GlobalVariable $global_variable,
        GlobalView $global_view,
        BackendTranslations $translation,
        )
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['permission:main-sidebar']);
        $this->middleware(['permission:main-index'])->only(['index']);
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->translation = $translation;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->TitlePage('Dashboard'),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),
            $this->global_variable->MessageNotification(),

            // Translation
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->main,

            // Module
            $this->global_variable->ModuleType([
                'main-home',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'main-home-js',
            ]),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.main.home');
    }
}
