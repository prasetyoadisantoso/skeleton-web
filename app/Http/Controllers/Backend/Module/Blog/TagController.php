<?php

namespace App\Http\Controllers\Backend\Module\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagFormRequest;
use App\Models\Tag;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TagController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $tag;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Tag $tag,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:blog-sidebar']);
        $this->middleware(['permission:tag-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:tag-create'])->only('create');
        $this->middleware(['permission:tag-edit'])->only('edit');
        $this->middleware(['permission:tag-store'])->only('store');
        $this->middleware(['permission:tag-update'])->only('update');
        $this->middleware(['permission:tag-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->tag = $tag;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([

            // Global Variable
            $this->global_variable->TitlePage($this->translation->tag['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->tag,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'tag-home',
                'tag-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'tag-home-js',
                'tag-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('tag.index'),
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
        return view('template.default.backend.module.blog.tag.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->tag->query())
            ->addColumn('name', function ($tag) {
                return $tag->name;
            })
            ->addColumn('slug', function ($tag) {
                return $tag->slug;
            })
            ->addColumn('action', function ($tag) {
                return $tag->id;
            })
            ->removeColumn('id')->addIndexColumn()->make('true');
        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->boot();
        return view('template.default.backend.module.blog.tag.form', array_merge(
            $this->global_variable->PageType('create'),
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($request->validator->messages());
        }
        $request->validated();
        $tagdata = $request->only(['name', 'slug']);

        DB::beginTransaction();
        try {

            // Store Tag Data
            $this->tag->StoreTag($tagdata);
            DB::commit();

            // Activity Log
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($this->translation->tag['messages']['store_success']);

            return redirect()->route('tag.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->tag['messages']['store_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            // Activity Log
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($message);

            return redirect()->route('tag.create')->with([
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
        $tagdata = $this->tag->GetTagById($id);
        return view('template.default.backend.module.blog.tag.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'tag' => $tagdata,
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
    public function update(TagFormRequest $request, $id)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($request->validator->messages());
        }

        $request->validated();
        $tagdata = $request->only(['name', 'slug']);

        DB::beginTransaction();
        try {
            // Update Tag
            $this->tag->UpdateTag($tagdata, $id);
            DB::commit();

            // Activity Log
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($this->translation->tag['messages']['update_success']);

            return redirect()->route('tag.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->meta['messages']['update_success'],
            ]);
        } catch (\Throwable$th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }

            // Activity Log
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($message);

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

            // Delete Tag
            $delete = $this->tag->DeleteTag($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            // Activity Log
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($this->translation->tag['messages']['delete_success']);

            ///  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            // Activity Log
            activity()->causedBy(Auth::user())->performedOn(new Tag)->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);

        }
    }
}
