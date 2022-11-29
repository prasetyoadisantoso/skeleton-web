<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CanonicalFormRequest;
use App\Models\Canonical;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CanonicalController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $canonical;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Canonical $canonical,
    )
    {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:seo-sidebar']);
        $this->middleware(['permission:canonical-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:canonical-create'])->only('create');
        $this->middleware(['permission:canonical-edit'])->only('edit');
        $this->middleware(['permission:canonical-store'])->only('store');
        $this->middleware(['permission:canonical-update'])->only('update');
        $this->middleware(['permission:canonical-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->canonical = $canonical;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->canonical['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),

            // Translations
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->notification,
            $this->translation->canonical,

            // Module
            $this->global_variable->ModuleType([
                'canonical-home',
                'canonical-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'canonical-home-js',
                'canonical-form-js',
            ]),

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
        return view('template.default.dashboard.settings.canonical.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        return $this->dataTables->of($this->canonical->query())
            ->addColumn('name', function ($canonical) {
                return $canonical->name;
            })
            ->addColumn('url', function ($canonical) {
                return $canonical->url;
            })
            ->addColumn('action', function ($canonical) {
                return $canonical->id;
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
        return view('template.default.dashboard.settings.canonical.form', array_merge(
            $this->global_variable->PageType('create'),
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CanonicalFormRequest $request)
    {
        $request->validated();
        $canonical_data = $request->only(['name', 'url']);

        DB::beginTransaction();
        try {
            $this->canonical->StoreCanonical($canonical_data);
            DB::commit();
            return redirect()->route('canonical.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->roles['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            return redirect()->route('canonical.create')->with([
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
        $data = $this->canonical->GetCanonicalById($id);
        return view('template.default.dashboard.settings.canonical.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'canonical' => $data,
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
    public function update(CanonicalFormRequest $request, $id)
    {
        $request->validated();
        $canonical = $request->only(['name', 'url']);

        DB::beginTransaction();
        try {
            $this->canonical->UpdateCanonical($canonical, $id);
            DB::commit();
            return redirect()->route('canonical.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->roles['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            return redirect()->route('role.create')->with([
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
            $delete = $this->canonical->DeleteCanonical($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            ///  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            $message = $th->getMessage();
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message
            ]);

        }
    }
}
