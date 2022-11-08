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
        $this->middleware(['auth', 'verified', 'xss', 'role:administrator']);

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
            $this->global_variable->TitlePage('Permissions'),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),

            // Translations
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->users,
            $this->translation->notification,

        ]);
    }

    public function index()
    {
        $this->boot();
        $this->fileManagement->Logging($this->responseFormatter->successResponse("Index Page: Success "));
    }

    public function index_dt()
    {
        $result = $this->dataTables->of($this->permission->query())
            ->addColumn('action', function ($permission) {
                return $permission->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');

        $this->fileManagement->Logging($this->responseFormatter->successResponse($result)->getContent());

    }

    public function create()
    {
        $this->boot();
        $this->fileManagement->Logging($this->responseFormatter->successResponse("Create Page: Success ")->getContent());
    }

    public function store(PermissionFormRequest $request)
    {
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
            $this->fileManagement->Logging($this->responseFormatter->successResponse("Store Success")->getContent());
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }

    }

    public function show($id)
    {
        # code...
    }

    public function edit($id)
    {
        $this->boot();
        $data = $this->permission->findById($id);
        $this->fileManagement->Logging($this->responseFormatter->successResponse($data)->getContent());
    }

    public function update(PermissionFormRequest $request, $id)
    {
        $request->validated();
        $validated_data = $request->only(['name']);
        $permission = $this->permission->findById($id);
        DB::beginTransaction();
        try {
            $permission = $this->permission->findById($id);
            $permission->name = $validated_data['name'];
            $permission->save();
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse("Update success"));
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
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

            $this->fileManagement->Logging($this->responseFormatter->successResponse($status));
        } catch (\Throwable$th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }
    }
}
