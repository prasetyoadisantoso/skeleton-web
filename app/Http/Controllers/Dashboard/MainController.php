<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\GlobalVariable;
use App\Services\Translations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $global, $translation;

    public function __construct(GlobalVariable $global, Translations $translation)
    {
        $this->middleware(['auth', 'verified', 'role:Administrator']);
        $this->global = $global;
        $this->translation = $translation;
    }

    public function index()
    {
        return response()->json([
            'report' => 'Success',
            'global_user' => $this->global->AuthUser(),
            'global_system_name' => $this->global->SystemName(),
            'sidebar_dashboard' => $this->translation->sidebar,
        ]);
    }
}
