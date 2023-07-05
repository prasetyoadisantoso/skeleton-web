<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionFormRequest;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    protected $global_view, $global_variable, $dataTables, $role, $translation, $responseFormatter, $fileManagement, $permission;

    public function __construct(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        Translations $translation,
        DataTables $dataTables,
        Permission $permission,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:user-sidebar']);
        $this->middleware(['permission:permission-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:permission-create'])->only('create');
        $this->middleware(['permission:permission-edit'])->only('edit');
        $this->middleware(['permission:permission-store'])->only('store');
        $this->middleware(['permission:permission-update'])->only('update');
        $this->middleware(['permission:permission-destroy'])->only('destroy');

        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;

        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->translation = $translation;

        $this->dataTables = $dataTables;
        $this->permission = $permission;
    }

    protected function boot()
    {
        // Render to View
        $this->global_view->RenderView([

            // Global Variable
            $this->global_variable->TitlePage($this->translation->permissions['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->permissions,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'permission-home',
                'permission-form'
            ]),

            // Script
            $this->global_variable->ScriptType([
                'permission-home-js',
                'permission-form-js'
            ]),

        ]);
    }

    public function index()
    {
        $this->boot();
        return view('template.default.dashboard.permissions.home',  array_merge(
            $this->global_variable->PageType('index')
        ));
    }

    public function index_dt()
    {
        $result = $this->dataTables->of($this->permission->query())
            ->addColumn('action', function ($permission) {
                return $permission->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');

        return $result;

    }

    public function create()
    {
        $this->boot();
        return view('template.default.dashboard.permissions.form', array_merge(
            $this->global_variable->PageType('create')
        ));
    }

    public function store(PermissionFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only([
            'name',
        ]);

        DB::beginTransaction();
        try {
            $this->permission->create([
                'name' => $validated_data['name'],
            ]);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($this->translation->permissions['messages']['store_success']);
            return redirect()->route('permission.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->permissions['messages']['store_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($message);

            return redirect()->route('permission.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }

    }

    public function edit($id)
    {
        $this->boot();
        $permission = $this->permission->findById($id);
        return view('template.default.dashboard.permissions.form', array_merge($this->global_variable->PageType('edit'), [
            "permission"=> $permission,
        ]));
    }

    public function update(PermissionFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only(['name']);
        $permission = $this->permission->findById($id);
        DB::beginTransaction();
        try {
            $permission = $this->permission->findById($id);
            $permission->name = $validated_data['name'];
            $permission->save();
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($this->translation->permissions['messages']['update_success']);
            return redirect()->route('permission.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->permissions['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($message);

            return redirect()->route('permission.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = $this->permission->findById($id)->delete();
            DB::commit();

            // check data deleted or not
            if ($delete == "true") {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($this->translation->permissions['messages']['delete_success']);

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            activity()->causedBy(Auth::user())->performedOn(new Permission)->log($message);
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);
        }
    }
}
