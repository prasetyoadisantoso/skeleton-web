<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Services\FileManagement;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\Translations;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    protected $fileManagement, $responseFormatter, $global_view, $global_variable, $user, $upload, $dataTables, $role;

    public function __construct(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        Translations $translation,
        DataTables $dataTables,
        Upload $upload,
        User $user,
        Role $role,
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;

        $this->middleware(['auth', 'verified', 'role:administrator']);
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->translation = $translation;

        $this->upload = $upload;
        $this->user = $user;
        $this->dataTables = $dataTables;
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
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->users,
            $this->translation->notification,

        ]);
    }

    public function index()
    {
        $this->boot();
        return view('template.default.dashboard.user.home');
    }

    public function index_dt()
    {
        $result = $this->dataTables->of($this->user->getUsersQueries())
            ->addColumn('image', function ($user) {
                return Storage::url($user->image);
            })
            ->addColumn('role', function ($user) {
                return $user->getRoleNames()->map(function ($item) {
                    return $item;
                })->implode('<br>');
            })
            ->addColumn('action', function ($user) {
                return $user->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');

        return $result;
    }

    public function create()
    {
        $this->boot();
        return view('template.default.dashboard.user.form', array_merge($this->global_variable->TypePage('create'), [
            'role_list' => $this->role->all()
        ]));
    }

    public function store(UserFormRequest $request)
    {
        $request->validated();
        $validated_data = $request->only(['name', 'email', 'password', 'image', 'phone', 'status', 'role']);

        DB::beginTransaction();
        try {
            if ($request->file('image')) {
                $image = $this->upload->UploadImageUserToStorage($validated_data['image']);
                $validated_data['image'] = $image;
            }
            $this->user->StoreUser($validated_data, $validated_data['role']);
            DB::commit();

            return redirect()->route('user.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->users['messages']['store_success']
            ]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            return redirect()->route('user.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);
        }
    }

    public function show($id)
    {
        $user = $this->user->GetUserByID($id);
        if($user->email_verified_at !== null){
            $is_verified = $this->translation->select['antonim']['yes'];
        } else {
            $is_verified = $this->translation->select['antonim']['no'];
        }
        $role = $user->getRoleNames();
        return $this->responseFormatter->successResponse(["user"=> $user, "role" => $role, "is_verified" => $is_verified], 'Get user detail by id');
    }

    public function edit($id)
    {
        $data_user = $this->user->GetUserByID($id);
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            'Input ID (hidden)' => $data_user->id,
            'Input Name' => $data_user->name,
            'Input Email' => $data_user->email,
            'Input Password' => '',
        ], 'Get user detail by id to place into each form field'));
    }

    public function update(TestFormRequest $test, $id)
    {
        $test->validated();
        $new_user_data = $test->only([
            'name', 'email', 'phone', 'image', 'password'
        ]);

        DB::beginTransaction();
        try {
            if ($test->file('image')) {
                $image = $this->upload->UploadImageUserToStorage($new_user_data['image']);
                $new_user_data['image'] = $image;
            }
            $result = $this->user->UpdateUser($new_user_data, $id);
            $this->fileManagement->Logging($this->responseFormatter->successResponse([
                'ID' => $id,
                'New Data' => $new_user_data,
                'Result' => $result,
            ], 'Update old user into new user'));
            DB::commit();
        } catch (\Throwable$th) {
            DB::rollback();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $delete = $this->user->DeleteUser($id);
            DB::commit();

            $this->fileManagement->Logging($this->responseFormatter->successResponse([
                'status' => $delete,
            ], 'Data deleted successfully'));
        } catch (\Throwable$th) {
            DB::rollback();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }
    }
}
