<?php

namespace App\Http\Controllers\Backend\Module\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\BackendTranslations;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    protected $global_view, $global_variable, $dataTables, $translation, $responseFormatter, $fileManagement, $role, $permission;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        DataTables $dataTables,
        BackendTranslations $translation,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Role $role,
        Permission $permission
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:user-sidebar']);
        $this->middleware(['permission:role-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:role-create'])->only('create');
        $this->middleware(['permission:role-edit'])->only('edit');
        $this->middleware(['permission:role-store'])->only('store');
        $this->middleware(['permission:role-update'])->only('update');
        $this->middleware(['permission:role-destroy'])->only('destroy');

        $this->fileManagement = $fileManagement;
        $this->responseFormatter = $responseFormatter;

        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->translation = $translation;

        $this->dataTables = $dataTables;
        $this->permission = $permission;
        $this->role = $role;

    }

    /**
     * Boot Service
     *
     */
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
            $this->translation->notification,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->roles,

            // Module
            $this->global_variable->ModuleType([
                'role-home',
                'role-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'role-home-js',
                'role-form-js',
            ]),

        ]);
    }

    public function index()
    {
        $this->boot();
        return view('template.default.backend.module.role.home', array_merge(
            $this->global_variable->PageType('index'))
        );
    }

    public function index_dt()
    {
        $result = $this->dataTables->of($this->role->query())
            ->addColumn('role', function ($role) {
                return $role->name;
            })
            ->addColumn('permission', function ($role) {
                return $role->permissions->pluck('name');
            })
            ->addColumn('action', function ($role) {
                return $role->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');

        return $result;
    }

    public function create()
    {
        $this->boot();
        $permissions = $permissions = $this->permission->query()->get()->toArray();
        return view('template.default.backend.module.role.form', array_merge(
            $this->global_variable->PageType('create'),
            [
                'permission_list' => $permissions,
            ]
        ));
    }

    public function store(RoleFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Role)->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only(['name', 'permissions']);

        DB::beginTransaction();
        try {
            $role = $this->role->create(['name' => $validated_data['name']]);
            $role->syncPermissions($validated_data['permissions']);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Role)->log($this->translation->roles['messages']['store_success']);
            return redirect()->route('role.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->roles['messages']['store_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Role)->log($message);

            return redirect()->route('role.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }

    public function edit($id)
    {
        $this->boot();
        $role = $this->role->findById($id);
        $current_permission = $role->permissions()->get()->toArray();
        $permissions = $this->permission->query()->get()->toArray();

        return view('template.default.backend.module.role.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'role' => $role,
                'permission_list' => $permissions,
                'current_permissions' => $current_permission,
            ]
        ));
    }

    public function update(RoleFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Role)->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only(['name', 'permissions']);

        DB::beginTransaction();
        try {
            $role = $this->role->findById($id);
            $role->update([
                "name" => $validated_data['name'],
            ]);
            $role->syncPermissions($validated_data['permissions']);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Role)->log($this->translation->roles['messages']['update_success']);
            return redirect()->route('role.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->roles['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Role)->log($message);

            return redirect()->back()->with([
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
            $delete = $this->role->findById($id)->delete();
            DB::commit();

            // check data deleted or not
            if ($delete == "true") {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Role)->log($this->translation->roles['messages']['delete_success']);

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new Role)->log($message);
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);
        }
    }
}
