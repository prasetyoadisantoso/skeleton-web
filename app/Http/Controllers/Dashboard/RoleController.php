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
            $this->global_variable->TitlePage('Users'),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),

            // Translations
            $this->translation->notification,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->roles,
            $this->translation->permissions,

        ]);
    }

    public function index()
    {
        $this->boot();
        $this->fileManagement->Logging($this->responseFormatter->successResponse("Index Page"));
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

        return $this->fileManagement->Logging($this->responseFormatter->successResponse($result));
    }

    public function create()
    {
        $this->boot();
        $permissions = $this->permission->query()->get();
        $this->fileManagement->Logging($this->responseFormatter->successResponse(array_merge($this->global_variable->PageType('create')), [
            'permissions' => $permissions,
        ]));
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

            $this->fileManagement->Logging($this->responseFormatter->successResponse("Success create role")->getContent());
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage())->getContent());
        }
    }

    public function edit($id)
    {
        $role = $this->role->findById($id);
        $permission = $role->permissions()->get();
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            $role, $permission
        ])->getContent());
    }

    public function update(RoleFormRequest $request, $id)
    {
        $request->validated();
        $validated_data = $request->only(['name', 'permissions']);

        DB::beginTransaction();
        try {
            $role = $this->role->findById($id);
            $role->update([
                "name" => $validated_data['name']
            ]);
            $role->syncPermissions($validated_data['permissions']);
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse("Success update data")->getContent());
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage())->getContent());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = $this->role->findById($id)->delete();
            DB::commit();
             // check data deleted or not
             if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }
            $this->fileManagement->Logging($this->responseFormatter->successResponse($status, "Success delete data")->getContent());
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage())->getContent());
        }
    }
}
