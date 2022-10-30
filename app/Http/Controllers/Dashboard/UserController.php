<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestFormRequest;
use App\Models\User;
use App\Services\FileManagement;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    protected $fileManagement, $responseFormatter, $user, $upload, $dataTables;

    public function __construct(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Upload $upload,
        User $user,
        DataTables $dataTables
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->upload = $upload;
        $this->user = $user;
        $this->dataTables = $dataTables;
    }

    public function index()
    {
        $this->fileManagement->Logging($this->responseFormatter->successResponse($this->user->GetAllUser(), 'Get all user data'));
    }

    public function index_dt()
    {
        $result = Datatables::of($this->user->getUsersQueries())
            ->addColumn('image', function ($user) {
                return Storage::url($user->image);
            })
            ->addColumn('roles', function ($user) {
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
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            'type' => 'form',
            'name' => 'Andy Reztyan',
            'email' => 'andy@email.com',
            'image' => 'profile.png',
            'password' => '123456',
        ], 'Get form input'));
    }

    public function store(TestFormRequest $test)
    {
        $test->validated();
        $validated_data = $test->only(['name', 'email', 'password', 'image', 'phone']);

        DB::beginTransaction();
        try {
            if ($test->file('image')) {
                $image = $this->upload->UploadImageUserToStorage($validated_data['image']);
                $validated_data['image'] = $image;
            }
            $result = $this->user->StoreUser($validated_data);
            $this->fileManagement->Logging($this->responseFormatter->successResponse($result, 'Data stored successfully'));
            DB::commit();
        } catch (\Throwable$th) {
            DB::rollback();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
        }
    }

    public function show($id)
    {
        $this->fileManagement->Logging($this->responseFormatter->successResponse($this->user->GetUserByID($id), 'Get user detail by id'));
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
            'name', 'email', 'password', 'image', 'password_confirmation',
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
