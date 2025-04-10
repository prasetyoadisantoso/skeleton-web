<?php

namespace App\Http\Controllers\Backend\Module\SEO;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpengraphFormRequest;
use App\Models\MediaLibrary;
use App\Models\Opengraph;
use App\Services\BackendTranslations;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class OpengraphController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $dataTables;
    protected $responseFormatter;
    protected $fileManagement;
    protected $opengraph;
    protected $upload;
    protected $mediaLibrary;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        BackendTranslations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Opengraph $opengraph,
        Upload $upload,
        MediaLibrary $mediaLibrary,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:seo-sidebar']);
        $this->middleware(['permission:opengraph-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:opengraph-create'])->only('create');
        $this->middleware(['permission:opengraph-edit'])->only('edit');
        $this->middleware(['permission:opengraph-store'])->only('store');
        $this->middleware(['permission:opengraph-update'])->only('update');
        $this->middleware(['permission:opengraph-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->opengraph = $opengraph;
        $this->upload = $upload;
        $this->mediaLibrary = $mediaLibrary;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->opengraph['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->opengraph,

            // Module
            $this->global_variable->ModuleType([
                'opengraph-home',
                'opengraph-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'opengraph-home-js',
                'opengraph-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('opengraph.index'),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.seo.opengraph.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        return $this->dataTables->of($this->opengraph->query())
        ->addColumn('title', function ($opengraph) {
            return $opengraph->og_title;
        })
        ->addColumn('description', function ($opengraph) {
            return $opengraph->og_description;
        })
        ->addColumn('type', function ($opengraph) {
            return $opengraph->og_type;
        })
        ->addColumn('url', function ($opengraph) {
            return $opengraph->og_url;
        })
        ->addColumn('action', function ($opengraph) {
            return $opengraph->id;
        })
        ->removeColumn('id')->addIndexColumn()->make('true');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->boot();

        return view('template.default.backend.module.seo.opengraph.form', array_merge(
            $this->global_variable->PageType('create'),
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OpengraphFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($request->validator->messages());
        }
        $request->validated();
        $opengraphData = $request->only(['og_title', 'og_description', 'og_type', 'og_url']);

        $media = null;

        DB::beginTransaction();
        try {
            // Upload image jika ada
            if ($request->hasFile('og_image')) {
                $imageFile = $request->file('og_image');
                $ogImage = $this->upload->UploadOpengraphImageToMediaLibrary($imageFile);

                // Simpan ke Media Library
                $media_data = [
                    'title' => pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME), // Ambil nama file tanpa ekstensi
                    'media-files' => $ogImage['media_path'],
                    'information' => '',
                    'description' => '',
                ];
                $media = new MediaLibrary();
                $media = $media->StoreMediaLibrary($media_data);
            }

            // Simpan Opengraph
            $opengraphData['og_image_id'] = $media ? $media->id : null;
            $opengraph = new Opengraph();
            $opengraph = $opengraph->StoreOpengraph($opengraphData);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($this->translation->opengraph['messages']['store_success']);

            return redirect()->route('opengraph.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->opengraph['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($message);

            return redirect()->route('opengraph.create')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->boot();
        $opengraph = $this->opengraph->GetOpengraphById($id);

        return view('template.default.backend.module.seo.opengraph.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'opengraph' => $opengraph,
            ]
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(OpengraphFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($request->validator->messages());
        }

        $request->validated();
        $opengraphData = $request->only(['og_title', 'og_description', 'og_type', 'og_url']);

        $opengraph = $this->opengraph->GetOpengraphById($id);

        // Handle Image Upload
        if ($request->hasFile('og_image')) {
            $imageFile = $request->file('og_image');
            $imageData = $this->upload->UploadOpengraphImageToMediaLibrary($imageFile);

            // Delete old image if exists
            if ($opengraph->og_image_id) {
                $oldImage = $this->mediaLibrary->GetMediaLibraryById($opengraph->og_image_id);
                if ($oldImage) {
                    Storage::delete('public/'.$oldImage->media_files);
                    $this->mediaLibrary->DeleteMediaLibrary($oldImage->id);
                }
            }

            // Create new MediaLibrary entry for image
            $imageMedia = MediaLibrary::create([
                'title' => pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME), // Gunakan nama file asli
                'media_files' => $imageData['media_path'], // Simpan path yang dikembalikan UploadImageLogoToStorage
                'information' => '',
                'description' => '',
            ]);

            $opengraph->og_image_id = $imageMedia->id;
        }

        // Update Opengraph
        $opengraph->og_title = $opengraphData['og_title'];
        $opengraph->og_description = $opengraphData['og_description'];
        $opengraph->og_type = $opengraphData['og_type'];
        $opengraph->og_url = $opengraphData['og_url'];

        $opengraph->save();

        DB::beginTransaction();
        try {
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($this->translation->opengraph['messages']['update_success']);

            return redirect()->route('opengraph.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->opengraph['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = $this->opengraph->GetOpengraphById($id);
            // Check if user has associated MediaLibrary records
            if ($delete->medialibraries()->exists()) {
                // Get existing media
                $existing_media = $delete->medialibraries()->first();
                // Delete the file from storage
                Storage::delete('public/'.$existing_media->media_files);
                // Delete the MediaLibrary record
                $existing_media->delete();
                // Set og_image_id to null
                $delete->og_image_id = null;
                $delete->save();
            }
            $delete = $this->opengraph->DeleteOpengraph($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($this->translation->opengraph['messages']['delete_success']);

            // /  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            activity()->causedBy(Auth::user())->performedOn(new Opengraph())->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }
}
