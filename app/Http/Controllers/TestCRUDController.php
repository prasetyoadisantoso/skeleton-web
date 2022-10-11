<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestFormRequest;
use App\Models\User;
use App\Services\FileManagement;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;

class TestCRUDController extends Controller
{
    public function index(
        User $user,
        FileManagement $filemanagement,
        ResponseFormatter $response)
    {
        $filemanagement->Logging($response->successResponse($user->GetAllUser(), 'Get all user data'));
    }

    public function create(
        FileManagement $filemanagement,
        ResponseFormatter $response)
    {
        $filemanagement->Logging($response->successResponse([
            'type' => 'form',
            'name' => 'Andy Reztyan',
            'email' => 'andy@email.com',
            'image' => 'profile.png',
            'password' => '123456',
        ], 'Get form input'));
    }

    public function store(
        TestFormRequest $test,
        User $user,
        FileManagement $filemanagement,
        Upload $upload,
        ResponseFormatter $response)
    {
        $test->validated();
        $validated_data = $test->only(['name', 'email', 'password', 'image']);

        DB::beginTransaction();
        try {
            if ($test->file('image')) {
                $image = $upload->UploadImageUserToStorage($validated_data['image']);
                $validated_data['image'] = $image;
            }
            $result = $user->StoreUser($validated_data);
            $filemanagement->Logging($response->successResponse($result, 'Data stored successfully'));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $filemanagement->Logging($response->errorResponse($th->getMessage()));
        }
    }

    public function show(
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter,
        User $user,
        $id)
    {
        $fileManagement->Logging($responseFormatter->successResponse($user->GetUserByID($id), 'Get user detail by id'));
    }

    public function edit(
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter,
        User $user,
        $id)
    {
        $data_user = $user->GetUserByID($id);
        $fileManagement->Logging($responseFormatter->successResponse([
            'Input ID (hidden)' => $data_user->id,
            'Input Name' => $data_user->name,
            'Input Email' => $data_user->email,
            'Input Password' => '',
        ], 'Get user detail by id to place into each form field'));
    }

    public function update(
        TestFormRequest $test,
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter,
        User $user,
        Upload $upload,
        $id)
    {
        $test->validated();
        $new_user_data = $test->only([
            'name', 'email', 'password', 'image', 'password_confirmation',
        ]);

        DB::beginTransaction();
        try {
            if ($test->file('image')) {
                $image = $upload->UploadImageUserToStorage($new_user_data['image']);
                $new_user_data['image'] = $image;
            }
            $result = $user->UpdateUser($new_user_data, $id);
            $fileManagement->Logging($responseFormatter->successResponse([
                'ID' => $id,
                'New Data' => $new_user_data,
                'Result' => $result,
            ], 'Update old user into new user'));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $fileManagement->Logging($responseFormatter->errorResponse($th->getMessage()));
        }
    }

    public function delete(
        FileManagement $fileManagement,
        ResponseFormatter $responseFormatter,
        User $user,
        $id)
    {
        DB::beginTransaction();
        try {
            $delete = $user->DeleteUser($id);
            DB::commit();

            $fileManagement->Logging($responseFormatter->successResponse([
                'status' => $delete,
            ], 'Data deleted successfully'));
        } catch (\Throwable $th) {
            DB::rollback();
            $fileManagement->Logging($responseFormatter->errorResponse($th->getMessage()));
        }
    }
}
