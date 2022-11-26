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
    ) {
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
        return $this->global_view->RenderView([
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
                'socialmedia-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'socialmedia-home-js',
                'socialmedia-form-js',
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
        return view('template.default.dashboard.settings.social.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        return $this->dataTables->of($this->social_media->query())
            ->addColumn('name', function ($social_media) {
                return $social_media->name;
            })
            ->addColumn('url', function ($social_media) {
                return $social_media->url;
            })
            ->addColumn('action', function ($social_media) {
                return $social_media->id;
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
        return view('template.default.dashboard.settings.social.form', array_merge(
            $this->global_variable->PageType('create'),
        ));
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
            return redirect()->route('social_media.index')->with([
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

            return redirect()->route('social_media.create')->with([
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
        $data = $this->social_media->GetSocialMediaById($id);
        return view('template.default.dashboard.settings.social.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'social_media' => $data,
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
    public function update(SocialMediaFormRequest $request, $id)
    {
        $request->validated();
        $social_media = $request->only(['name', 'url']);

        DB::beginTransaction();
        try {
            $this->social_media->UpdateSocialMedia($social_media, $id);
            DB::commit();
            return redirect()->route('social_media.index')->with([
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
            $delete = $this->social_media->DeleteSocialMedia($id);
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
