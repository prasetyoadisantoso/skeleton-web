<?php

namespace App\Http\Controllers\Backend\Module\Users;

use App\Http\Controllers\Backend\Module\MediaLibrary\MediaLibraryController;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\MediaLibrary;
use App\Models\User;
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $user;
    protected $upload;
    protected $dataTables;
    protected $translation;
    protected $role;
    protected $responseFormatter;
    protected $mediaLibraryController;

    public function __construct(
        ResponseFormatter $responseFormatter,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        BackendTranslations $translation,
        DataTables $dataTables,
        Upload $upload,
        User $user,
        Role $role,
        MediaLibraryController $mediaLibraryController,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:user-sidebar']);
        $this->middleware(['permission:user-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:user-create'])->only('create');
        $this->middleware(['permission:user-edit'])->only('edit');
        $this->middleware(['permission:user-show'])->only('show');
        $this->middleware(['permission:user-store'])->only('store');
        $this->middleware(['permission:user-update'])->only('update');
        $this->middleware(['permission:user-destroy'])->only('destroy');

        $this->responseFormatter = $responseFormatter;
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->translation = $translation;

        $this->upload = $upload;
        $this->user = $user;
        $this->dataTables = $dataTables;
        $this->role = $role;
        $this->mediaLibraryController = $mediaLibraryController;
    }

    /**
     * Boot Service.
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
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->users,

            // Module
            $this->global_variable->ModuleType([
                'user-home',
                'user-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'user-home-js',
                'user-form-js',
            ]),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.user.home', array_merge(
            $this->global_variable->PageType('index')
        ));
    }

    public function index_dt()
    {
        $result = $this->dataTables->of($this->user->getUsersQueries())
            ->addColumn('image', function ($user) {
                $imageUrl = '';
                if ($user->medialibraries->isNotEmpty()) {
                    $mediaLibrary = $user->medialibraries->first(); // Assuming one image per user
                    if ($mediaLibrary->media_files) {
                        $imageUrl = Storage::url($mediaLibrary->media_files);
                    }
                }

                return $imageUrl;
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

        return view('template.default.backend.module.user.form', array_merge(
            $this->global_variable->PageType('create'),
            [
                'role_list' => $this->role->all(),
            ]
        ));
    }

    public function store(UserFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User())->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only(['name', 'email', 'password', 'image', 'phone', 'status', 'role']);
        $user_data = Arr::except($validated_data, ['image']);

        DB::beginTransaction();
        try {
            $user = $this->user->StoreUser($user_data, $user_data['role']);
            if ($request->file('image')) {
                // Use Media Library to store image
                $this->mediaLibraryController->storeImageUser($validated_data['image'], $user);
            }

            activity()->causedBy(Auth::user())->performedOn(new User())->log($this->translation->users['messages']['store_success']);
            DB::commit();

            return redirect()->route('user.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->users['messages']['store_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new User())->log($message);

            return redirect()->route('user.create')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }

    public function show($id)
    {
        $user = $this->user->GetUserByID($id);
        if ($user->email_verified_at !== null) {
            $is_verified = $this->translation->select['antonim']['yes'];
        } else {
            $is_verified = $this->translation->select['antonim']['no'];
        }
        $role = $user->getRoleNames();
        // Check if the user has a related MediaLibrary record
        if ($user->medialibraries()->exists()) {
            $image = $user->medialibraries->first()->media_files;
        } else {
            // Set a default image path if no image is found
            $image = null;
        }

        return $this->responseFormatter->successResponse(['user' => $user, 'image' => $image,  'role' => $role, 'is_verified' => $is_verified], 'Get user detail by id');
    }

    public function edit($id)
    {
        $this->boot();
        $user = $this->user->GetUserByID($id);
        $role = $user->getRoleNames();
        if ($user->email_verified_at !== null) {
            $is_verified = $this->translation->select['antonim']['yes'];
        } else {
            $is_verified = $this->translation->select['antonim']['no'];
        }

        // Check if the user has a related MediaLibrary record
        if ($user->medialibraries()->exists()) {
            $image = $user->medialibraries->first()->media_files;
        } else {
            // Set a default image path if no image is found
            $image = null;
        }

        return view('template.default.backend.module.user.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'user' => $user,
                'role' => $role,
                'image' => $image,
                'role_list' => $this->role->all(),
                'is_verified' => $is_verified,
            ]
        ));
    }

    public function update(UserFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new User())->log($request->validator->messages());
        }

        $request->validated();
        $new_user_data = $request->only(['name', 'email', 'password', 'image', 'phone', 'status', 'role']);

        DB::beginTransaction();
        try {
            if ($request->file('image')) {
                // Use Media Library to store image
                $this->mediaLibraryController->updateImageUser($new_user_data['image'], $id);
            }

            $user_data = Arr::except($new_user_data, ['image']);
            $this->user->UpdateUser($user_data, $id, $new_user_data['role']);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new User())->log($this->translation->users['messages']['update_success']);

            return redirect()->route('user.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->users['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new User())->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Get the User
            $user = $this->user->GetUserByID($id);

            // Check if user has associated MediaLibrary records
            if ($user->medialibraries()->exists()) {
                // Get existing media
                $existing_media = $user->medialibraries()->first();

                // Delete the file from storage
                Storage::delete('public/'.$existing_media->media_files);

                // Detach the media from the user
                $user->medialibraries()->detach($existing_media->id);

                // Delete the MediaLibrary record
                $existing_media->delete();
            }
            $delete = $this->user->DeleteUser($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new User())->log($this->translation->users['messages']['delete_success']);

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new User())->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }
}
