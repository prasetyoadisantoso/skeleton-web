<?php

namespace App\Http\Controllers\Backend\Module\SEO;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpengraphFormRequest;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Yajra\DataTables\DataTables;
Use App\Models\Opengraph;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OpengraphController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $opengraph, $upload;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Opengraph $opengraph,
        Upload $upload,
    )
    {
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
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->opengraph['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->opengraph,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'opengraph-home',
                'opengraph-form'
            ]),

            // Script
            $this->global_variable->ScriptType([
                'opengraph-home-js',
                'opengraph-form-js'
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
        ->addColumn('name', function($opengraph){
            return $opengraph->name;
        })
        ->addColumn('title', function($opengraph){
            return $opengraph->title;
        })
        ->addColumn('description', function($opengraph){
            return $opengraph->description;
        })
        ->addColumn('url', function($opengraph){
            return $opengraph->url;
        })
        ->addColumn('site_name', function($opengraph){
            return $opengraph->site_name;
        })
        ->addColumn('image', function($opengraph){
            return $opengraph->image;
        })
        ->addColumn('type', function($opengraph){
            return $opengraph->type;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpengraphFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($request->validator->messages());
        }
        $request->validated();
        $opengraph = $request->only(['name', 'title', 'description', 'url', 'site_name', 'image', 'type']);
        if ($request->file('image')) {
            $image = $this->upload->UploadOpengraphImageToStorage($opengraph['image']);
            $opengraph['image'] = $image;
        }

        DB::beginTransaction();
        try {
            $this->opengraph->StoreOpengraph($opengraph);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($this->translation->opengraph['messages']['store_success']);
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

            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($message);

            return redirect()->route('opengraph.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OpengraphFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($request->validator->messages());
        }

        $request->validated();
        $opengraph = $request->only(['name', 'title', 'description', 'url', 'site_name', 'image', 'type']);

        if ($request->file('image')) {
            $image = $this->upload->UploadOpengraphImageToStorage($opengraph['image']);
            $opengraph['image'] = $image;
        }

        DB::beginTransaction();
        try {$this->opengraph->UpdateOpengraph($opengraph, $id);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($this->translation->opengraph['messages']['update_success']);
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

            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $delete = $this->opengraph->DeleteOpengraph($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($this->translation->opengraph['messages']['delete_success']);

            ///  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            activity()->causedBy(Auth::user())->performedOn(new Opengraph)->log($message);
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);

        }
    }
}
