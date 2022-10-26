<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\GlobalVariable;
use App\Services\Translations;

class MainController extends Controller
{
    protected $global, $translation;

    public function __construct(GlobalVariable $global, Translations $translation)
    {
        $this->middleware(['auth', 'verified', 'role:Administrator']);
        $this->global = $global;
        $this->translation = $translation;

        // Global Variable
        $global->GlobalAdmin('Dashboard');
        $global->GlobalLanguage();
    }

    public function index()
    {
        $global_user_name = $this->global->AuthUser()->only(['name']);
        $global_system_name = $this->global->SystemName();
        $translation_sidebar =  $this->translation->sidebar;
        $translation_main = $this->translation->main;

        return view('template.default.dashboard.main.home', array_merge($global_user_name, $global_system_name, $translation_sidebar, $translation_main));
    }
}
