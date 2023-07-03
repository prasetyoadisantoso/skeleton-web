<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Translations;
use Yajra\DataTables\DataTables;

class MessageController extends Controller
{

    protected $global_view, $global_variable, $translation, $dataTables, $message;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        Message $message,
    )
    {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:setting-sidebar']);
        $this->middleware(['permission:message-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:message-create'])->only('create');
        $this->middleware(['permission:message-edit'])->only('edit');
        $this->middleware(['permission:message-store'])->only('store');
        $this->middleware(['permission:message-update'])->only('update');
        $this->middleware(['permission:message-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->mesage = $message;
    }

    protected function boot()
    {
        return [
            $this->global_variable->TitlePage($this->translation->meta['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),

            // Translations
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->message,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'message-home',
                'message-form'
            ]),

            // Script
            $this->global_variable->ScriptType([
                'message-home-js',
                'message-form-js'
            ]),

            // Route Type
            $this->global_variable->RouteType('message.index'),
        ];
        // return $this->global_view->RenderView();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->boot();
        return response()->json([
            "boot" => $this->boot(),
            "type" => $this->global_variable->PageType('index'),
        ]);
        // return view('template.default.dashboard.seo.meta.home', array_merge(
        //     $this->global_variable->PageType('index'),
        // ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
