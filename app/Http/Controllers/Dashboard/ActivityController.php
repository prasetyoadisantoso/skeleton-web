<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $activity, $user;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        FileManagement $fileManagement,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        Activity $activity,
        User $user,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:system-sidebar']);
        $this->middleware(['permission:activity-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:activity-create'])->only('create');
        $this->middleware(['permission:activity-edit'])->only('edit');
        $this->middleware(['permission:activity-store'])->only('store');
        $this->middleware(['permission:activity-update'])->only('update');
        $this->middleware(['permission:activity-destroy'])->only(['destroy', 'empty']);
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->activity = $activity;
        $this->user = $user;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->activity['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->notification,
            $this->translation->activity,

            // Module
            $this->global_variable->ModuleType([
                'activity-home',
                'activity-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'activity-home-js',
                'activity-form-js',
            ]),

        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->boot();
        return view('template.default.dashboard.system.activity.home', array_merge(
            $this->global_variable->PageType('index')
        ));
    }

    public function index_dt()
    {
        return $this->dataTables->of($this->activity->query())
            ->addColumn('ip_address', function ($activity) {
                return $activity->properties;
            })
            ->addColumn('user', function ($activity) {
                $user = $this->user->GetUserByID($activity->causer_id);
                return $user;
            })
            ->addColumn('activity', function ($activity) {
                return $activity->description;
            })
            ->addColumn('model', function ($activity) {
                return $activity->subject_type;
            })
            ->addColumn('date', function ($activity) {
                return $activity->created_at;
            })
            ->addColumn('action', function ($activity) {
                return $activity->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');
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
        DB::beginTransaction();
        try {
            $delete = DB::table('activity_log')->where('id', '=', $id)->delete();
            DB::commit();

            // check data deleted or not
            if ($delete == 1) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            ///  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function empty()
    {
        DB::beginTransaction();
        try {
            DB::table('activity_log')->delete();
            DB::commit();
            ///  Return response
            return response()->json(['status' => 'success']);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }
}
