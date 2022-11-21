<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MetaFormRequest;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
Use App\Models\Meta;
use Illuminate\Support\Facades\DB;

class MetaController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $meta;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Meta $meta,
    )
    {
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
        // return $this->global_view->RenderView([]);

        return [
            $this->global_variable->TitlePage($this->translation->meta['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),

            // Translations
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->meta,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'meta-home',
                'meta-form'
            ]),

            // Script
            $this->global_variable->ScriptType([
                'meta-home-js',
                'meta-form-js'
            ]),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->fileManagement->Logging($this->responseFormatter->successResponse($this->boot())->getContent());
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->meta->query())
        ->addColumn('name', function($meta){
            return $meta->name;
        })
        ->addColumn('robot', function($meta){
            return $meta->robot;
        })
        ->addColumn('description', function($meta){
            return $meta->name;
        })
        ->addColumn('keyword', function($meta){
            return $meta->keyword;
        })
        ->addColumn('action', function ($meta) {
            return $meta->id;
        })
        ->removeColumn('id')->addIndexColumn()->make('true');
        return $this->fileManagement->Logging($this->responseFormatter->successResponse($res));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->fileManagement->Logging($this->responseFormatter->successResponse($this->boot()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MetaFormRequest $request)
    {
        $request->validated();
        $metadata = $request->only(['name', 'robot', 'description', 'keyword']);

        DB::beginTransaction();
        try {
            $result = $this->meta->StoreMeta($metadata);
            DB::commit();
            return $this->fileManagement->Logging($this->responseFormatter->successResponse($result)->getContent());
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage())->getContent());
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
        $metadata = $this->meta->GetMetaById($id);
        return $this->fileManagement->Logging($this->responseFormatter->successResponse($metadata)->getContent());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $metadata = $this->meta->GetMetaById($id);
        return $this->fileManagement->Logging($this->responseFormatter->successResponse($this->boot(), $metadata)->getContent());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MetaFormRequest $request, $id)
    {
        $request->validated();
        $metadata = $request->only(['name', 'robot', 'description', 'keyword']);

        DB::beginTransaction();
        try {
            $result = $this->meta->UpdateMeta($metadata, $id);
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse($result));
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
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
            $delete = $this->meta->DeleteMeta($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            //  Return response
            $this->fileManagement->Logging($this->responseFormatter->successResponse(['status' => $status]));
        } catch (\Throwable$th) {
            DB::rollback();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));

        }
    }
}
