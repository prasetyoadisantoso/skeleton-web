<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\GlobalView;
use Illuminate\Http\Request;
use App\Services\GlobalVariable;

class MainController extends Controller
{
    protected $global_view, $global_variable;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
    )
    {
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
    }

    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->SiteLogo(),
            $this->global_variable->SiteFavicon(),
        ]);
    }

    public function index()
    {
        $this->boot();
        return view('welcome');
    }
}
