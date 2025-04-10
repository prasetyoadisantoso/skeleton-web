<?php

namespace App\Http\Controllers\Backend\Module\SEO;

use App\Http\Controllers\Controller;
use App\Http\Requests\MetaFormRequest;
use App\Models\Meta;
use App\Services\BackendTranslations;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MetaController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $dataTables;
    protected $responseFormatter;
    protected $fileManagement;
    protected $meta;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        BackendTranslations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Meta $meta,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:seo-sidebar']);
        $this->middleware(['permission:meta-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:meta-create'])->only('create');
        $this->middleware(['permission:meta-edit'])->only('edit');
        $this->middleware(['permission:meta-store'])->only('store');
        $this->middleware(['permission:meta-update'])->only('update');
        $this->middleware(['permission:meta-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->meta = $meta;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->meta['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->meta,

            // Module
            $this->global_variable->ModuleType([
                'meta-home',
                'meta-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'meta-home-js',
                'meta-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('meta.index'),
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

        return view('template.default.backend.module.seo.meta.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        return $this->dataTables->of($this->meta->query())
        ->addColumn('title', function ($meta) {
            return $meta->title;
        })
        ->addColumn('description', function ($meta) {
            return $meta->description;
        })
        ->addColumn('keywords', function ($meta) {
            return $meta->keywords;
        })
        ->addColumn('action', function ($meta) {
            return $meta->id;
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

        return view('template.default.backend.module.seo.meta.form', array_merge(
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
    public function store(MetaFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($request->validator->messages());
        }
        $request->validated();
        $metadata = $request->only(['title', 'description', 'keyword']);

        DB::beginTransaction();
        try {
            $this->meta->StoreMeta($metadata);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($this->translation->meta['messages']['store_success']);

            return redirect()->route('meta.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->meta['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($message);

            return redirect()->route('meta.create')->with([
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
        $metadata = $this->meta->GetMetaById($id);

        return $this->fileManagement->Logging($this->responseFormatter->successResponse($metadata)->getContent());
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
        $metadata = $this->meta->GetMetaById($id);

        return view('template.default.backend.module.seo.meta.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'meta' => $metadata,
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
    public function update(MetaFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($request->validator->messages());
        }

        $request->validated();
        $metadata = $request->only(['title', 'description', 'keyword']);
        $metadata['keywords'] = $metadata['keyword'];

        DB::beginTransaction();
        try {
            $this->meta->UpdateMeta($metadata, $id);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($this->translation->meta['messages']['update_success']);

            return redirect()->route('meta.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->meta['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($message);

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
            $delete = $this->meta->DeleteMeta($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($this->translation->meta['messages']['delete_success']);

            // /  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new Meta())->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }
}
