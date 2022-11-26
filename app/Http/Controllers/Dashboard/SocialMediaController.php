<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialMediaFormRequest;
use App\Models\SocialMedia;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SocialMediaController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $social_media;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        SocialMedia $social_media,
    )
    {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:setting-sidebar']);
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->social_media = $social_media;
    }

    protected function boot()
    {
        // return $this->global_view->RenderView([
        // ]);

        return [
            $this->global_variable->TitlePage($this->translation->social_media['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),

            // Translations
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->notification,
            $this->translation->social_media,

            // Module
            $this->global_variable->ModuleType([
                'socialmedia-home',
                'socialmedia-form'
            ]),

            // Script
            $this->global_variable->ScriptType([
                'socialmedia-home-js',
                'socialmedia-form-js'
            ]),

            // Route Type
            $this->global_variable->RouteType('meta.index'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->fileManagement->Logging($this->responseFormatter->successResponse(['view' => $this->boot(), 'datatable' => $this->index_dt()])->getContent());
    }

    public function index_dt()
    {
        return $this->dataTables->of($this->social_media->query())
        ->addColumn('name', function($social_media){
            return $social_media->name;
        })
        ->addColumn('url', function($social_media){
            return $social_media->url;
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
        $this->fileManagement->Logging($this->responseFormatter->successResponse([
            'view' => $this->boot(),
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocialMediaFormRequest $request)
    {
        $request->validated();
        $social_media = $request->only(['name', 'url']);

        DB::beginTransaction();
        try {
            $this->social_media->StoreSocialMedia($social_media);
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse('store success'));
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($th->getMessage()));
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
        $data = $this->social_media->GetSocialMediaById($id);
        $this->fileManagement->Logging($this->responseFormatter->successResponse($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SocialMediaFormRequest $request, $id)
    {
        $request->validated();
        $social_media = $request->only(['name', 'url']);

        DB::beginTransaction();
        try {
            $this->social_media->UpdateSocialMedia($social_media, $id);
            DB::commit();
            $this->fileManagement->Logging($this->responseFormatter->successResponse('update success'));
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
            $delete = $this->social_media->DeleteSocialMedia($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            $this->fileManagement->Logging($this->responseFormatter->successResponse($status));
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($message));

        }
    }
}
