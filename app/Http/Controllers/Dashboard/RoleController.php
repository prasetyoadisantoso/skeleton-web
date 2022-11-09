<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    protected $global_view, $global_variable, $dataTables, $translation, $responseFormatter, $fileManagement, $role, $permission;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        DataTables $dataTables,
        Translations $translation,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Role $role,
        Permission $permission
    ) {
        $this->middleware(['auth', 'verified', 'xss', 'role:administrator']);

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

            // Translations
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
        return view('template.default.dashboard.role.home', array_merge(
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
        return view('template.default.dashboard.role.form', array_merge(
            $this->global_variable->PageType('create'),
            [
                'permission_list' => $permissions,
            ]
        ));
    }

    public function store(RoleFormRequest $request)
    {
        $request->validated();
        $validated_data = $request->only(['name', 'permissions']);

        DB::beginTransaction();
        try {
            $role = $this->role->create(['name' => $validated_data['name']]);
            $role->syncPermissions($validated_data['permissions']);
            DB::commit();

            return redirect()->route('role.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->roles['messages']['store_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

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

        return view('template.default.dashboard.role.form', array_merge(
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
            return redirect()->route('role.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->roles['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

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

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);
        }
    }
}
