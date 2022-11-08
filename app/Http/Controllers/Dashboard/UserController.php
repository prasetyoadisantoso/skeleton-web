<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
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

    protected $global_view, $global_variable, $user, $upload, $dataTables, $translation, $role;

    public function __construct(
        GlobalVariable $global_variable,
        GlobalView $global_view,
        Translations $translation,
        DataTables $dataTables,
        Upload $upload,
        User $user,
        Role $role,
    ) {
        $this->middleware(['auth', 'verified', 'xss', 'role:administrator']);

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
        $this->boot();
        $user = $this->user->GetUserByID($id);
        $role = $user->getRoleNames();
        if($user->email_verified_at !== null){
            $is_verified = $this->translation->select['antonim']['yes'];
        } else {
            $is_verified = $this->translation->select['antonim']['no'];
        }
        return view('template.default.dashboard.user.form', array_merge($this->global_variable->TypePage('edit'), [
            "user"=> $user,
            "role" => $role,
            'role_list' => $this->role->all(),
            "is_verified" => $is_verified,
        ]));
    }

    public function update(UserFormRequest $request, $id)
    {
        $request->validated();
        $new_user_data = $request->only(['name', 'email', 'password', 'image', 'phone', 'status', 'role']);

        DB::beginTransaction();
        try {
            if ($request->file('image')) {
                $image = $this->upload->UploadImageUserToStorage($new_user_data['image']);
                $new_user_data['image'] = $image;
            }
            $this->user->UpdateUser($new_user_data, $id, $new_user_data['role']);
            DB::commit();
            return redirect()->route('user.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->users['messages']['update_success']
            ]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = $this->user->DeleteUser($id);
            DB::commit();

            // check data deleted or not
            if ($delete == 1) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();

            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);
        }
    }
}
