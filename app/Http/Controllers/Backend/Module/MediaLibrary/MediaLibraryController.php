<?php

namespace App\Http\Controllers\Backend\Module\MediaLibrary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MediaLibraryFormRequest;
use App\Models\MediaLibrary;
use App\Services\Upload;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Yajra\DataTables\DataTables;
use App\Services\BackendTranslations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaLibraryController extends Controller
{
    protected $upload;

    protected $medialibrary, $global_variable, $global_view, $dataTables, $translation;

    public function __construct(
        Upload $upload,
        MediaLibrary $medialibrary,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        DataTables $dataTables,
        BackendTranslations $translation,
    ) {

        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->only(['store', 'update']);
        $this->middleware(['xss-sanitize'])->only(['store', 'update']);
        $this->middleware(['permission:medialibrary-sidebar']);
        $this->middleware(['permission:medialibrary-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:medialibrary-create'])->only('create');
        $this->middleware(['permission:medialibrary-edit'])->only('edit');
        $this->middleware(['permission:medialibrary-store'])->only('store');
        $this->middleware(['permission:medialibrary-update'])->only('update');
        $this->middleware(['permission:medialibrary-destroy'])->only('destroy');

        $this->upload = $upload;
        $this->medialibrary = $medialibrary;
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->dataTables = $dataTables;
        $this->translation = $translation;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([

            // Global Variable
            $this->global_variable->TitlePage($this->translation->medialibrary['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->medialibrary,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'medialibrary-home',
                'medialibrary-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'medialibrary-home-js',
                'medialibrary-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('media-library.index'),
        ]);
    }

    public function index()
    {
        $this->boot();
        $data = $this->medialibrary->get();
        return view('template.default.backend.module.medialibrary.home', array_merge($this->global_variable->PageType('index'), [
            'data' => $data
        ]));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->medialibrary->query()->orderBy('created_at', 'DESC'))
            ->addColumn('title', function ($data) {
                return $data->title;
            })
            ->addColumn('media_files', function ($data) {
                return Storage::url($data->media_files);
            })
            ->addColumn('action', function ($data) {
                return $data->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');
        return $res;
    }

    public function create()
    {
        $this->boot();

        return view('template.default.backend.module.medialibrary.form', array_merge(
            $this->global_variable->PageType('create')
        ));
    }

    public function store(MediaLibraryFormRequest $request)
    {
        $request->validated();
        $data = $request->only(['title', 'information', 'description', 'media-files']);

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary)->log($request->validator->messages());
        }

        DB::beginTransaction();
        try {

            // Upload function
            if ($request->file('media-files') != null) {
                $media_file = $this->upload->UploadFileMediaLibrary($data['media-files']);
                $data['media-files'] = $media_file['media_path'];

                if (isset($data['title']) && $data['title'] != "") {
                    $data['title'] = $data['title'];
                } else {
                    $data['title'] = $media_file['media_name'];
                }

            } else {
                $error = 'Media file not found';
            }

            if (isset($error)) {
                throw new Exception($error, 1);
            }

            // Store Data
            $this->medialibrary->StoreMediaLibrary($data);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary())->log($this->translation->medialibrary['messages']['store_success']);
            return redirect()->route('media-library.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->medialibrary['messages']['store_success'],
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary())->log($message);
            return redirect()->route('media-library.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }

    }

    public function show()
    {
    }

    public function edit($id)
    {
        $this->boot();
        $medialibrarydata = $this->medialibrary->GetMediaLibraryById($id);
        $pathInfo = pathinfo($medialibrarydata->media_files);

        return view('template.default.backend.module.medialibrary.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'medialibrarydata' => $medialibrarydata,
                'basename' => $pathInfo['basename'],
                'extensions' => $pathInfo['extension'],
                'mediafile' => $medialibrarydata->media_files,
            ]
        ));
    }

    public function update(MediaLibraryFormRequest $request, $id)
    {

        $request->validated();
        $data = $request->only(['title', 'information', 'description']);

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary)->log($request->validator->messages());
        }

        DB::beginTransaction();
        try {

            $this->medialibrary->UpdateMediaLibrary($id, $data);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary())->log($this->translation->medialibrary['messages']['update_success']);
            return redirect()->route('media-library.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->medialibrary['messages']['store_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary())->log($message);
            return redirect()->route('media-library.edit')->with([
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
            $delete = $this->medialibrary->DeleteMediaLibrary($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary)->log($this->translation->post['messages']['delete_success']);

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary)->log($message);
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }
}
