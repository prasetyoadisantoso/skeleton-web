<?php

namespace App\Http\Controllers\Backend\Module\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Canonical;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Opengraph;
use App\Models\Post;
use App\Models\Tag;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use App\Services\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $global_view, $global_variable, $translation, $dataTables, $responseFormatter, $fileManagement, $post, $category, $tag, $meta, $opengraph, $canonical, $upload;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        Translations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Upload $upload,
        Post $post,
        Category $category,
        Tag $tag,
        Meta $meta,
        Opengraph $opengraph,
        Canonical $canonical,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->except(['store', 'update']);
        $this->middleware(['xss-sanitize'])->only(['store', 'update']);
        $this->middleware(['permission:blog-sidebar']);
        $this->middleware(['permission:post-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:post-create'])->only('create');
        $this->middleware(['permission:post-edit'])->only('edit');
        $this->middleware(['permission:post-store'])->only('store');
        $this->middleware(['permission:post-update'])->only('update');
        $this->middleware(['permission:post-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
        $this->meta = $meta;
        $this->canonical = $canonical;
        $this->upload = $upload;
        $this->opengraph = $opengraph;

    }

    protected function boot()
    {
        return $this->global_view->RenderView([

            // Global Variable
            $this->global_variable->TitlePage($this->translation->post['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->post,
            $this->translation->notification,

            // Module
            $this->global_variable->ModuleType([
                'post-home',
                'post-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'post-home-js',
                'post-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('post.index'),
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
        return view('template.default.backend.module.blog.post.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->post->query()->orderBy('published_at', 'DESC'))
            ->addColumn('title', function ($post) {
                return $post->title;
            })
            ->addColumn('image', function ($post) {
                return Storage::url($post->feature_image);
            })
            ->addColumn('publish', function ($post) {
                if($post->published_at == null || $post->published_at == '' || $post->published_at == 'null'){
                    return "";
                }

                if($post->published_at != null) {
                    return $post->published_at->format('M d, Y');
                }

            })
            ->addColumn('action', function ($post) {
                return $post->id;
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
        $category_select = $this->category->query()->get();
        $tag_select = $this->tag->query()->get();
        $meta_select = $this->meta->query()->get();
        $opengraph_select = $this->opengraph->query()->get();
        $canonical_select = $this->canonical->query()->get();
        return view('template.default.backend.module.blog.post.form', array_merge(
            $this->global_variable->PageType('create'),
            [
                'category_select' => $category_select,
                'tag_select' => $tag_select,
                'meta_select' => $meta_select,
                'opengraph_select' => $opengraph_select,
                'canonical_select' => $canonical_select,
            ]
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostFormRequest $request)
    {

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Post)->log($request->validator->messages());
        }

        $request->validated();
        $post_data = $request->only(['title', 'slug', 'content', 'category', 'tag', 'meta', 'canonical', 'opengraph','feature_image', 'published']);
        $post_data['author_id'] = Auth::user()->id;

        if ($request->file('feature_image')) {
            $feature_image = $this->upload->UploadFeatureImageToStorage($post_data['feature_image']);
            $post_data['feature_image'] = $feature_image;
        }

        DB::beginTransaction();
        try {

            $this->post->StorePost($post_data);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Post)->log($this->translation->post['messages']['store_success']);
            return redirect()->route('post.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->post['messages']['store_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new Post)->log($message);
            return redirect()->route('post.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file;
        $image = $this->upload->UploadPostImageToStorage($file);
        return Storage::url($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->post->GetPostById($id);
        $category = $post->categories()->first();
        $tag = $post->tags()->get();
        $meta = $post->metas()->first();
        $opengraph = $post->opengraphs()->first();
        $canonical = $post->canonicals()->first();

        $category_select = $this->category->query()->get();
        $tag_select = $this->tag->query()->get();
        $meta_select = $this->meta->query()->get();
        $opengraph_select = $this->opengraph->query()->get();
        $canonical_select = $this->canonical->query()->get();
        $author = $post->author()->first();
        if($post->published_at == null || $post->published_at == '' || $post->published_at == 'null'){
            $published = "No";
        }

        if($post->published_at != null) {
            $published = "Yes";
        }

        foreach ($tag as $value) {
            $tag_selection[] = $value->id;
        }

        if(!isset($tag_selection)){
            $tag_selection = [];
        }

        return $this->responseFormatter->successResponse([
                'post' => $post,
                'content' => $post->content,
                'category' => $category,
                'tag' => $tag,
                'meta' => $meta,
                'canonical' => $canonical,
                'opengraph' => $opengraph,
                'category_select' => $category_select,
                'tag_select' => $tag_select,
                'tag_selection' => $tag_selection,
                'meta_select' => $meta_select,
                'opengraph_select' => $opengraph_select,
                'canonical_select' => $canonical_select,
                'author' => $author,
                'published' => $published,
        ]);
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
        $post = $this->post->GetPostById($id);
        $category = $post->categories()->first();
        $tag = $post->tags()->get();
        $meta = $post->metas()->first();
        $canonical = $post->canonicals()->first();
        $opengraph = $post->opengraphs()->first();

        $category_select = $this->category->query()->get();
        $tag_select = $this->tag->query()->get();
        $meta_select = $this->meta->query()->get();
        $opengraph_select = $this->opengraph->query()->get();
        $canonical_select = $this->canonical->query()->get();

        foreach ($tag as $value) {
            $tag_selection[] = $value->id;
        }

        if(!isset($tag_selection)){
            $tag_selection = [];
        }

        return view('template.default.backend.module.blog.post.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'post' => $post,
                'category' => $category,
                'tag' => $tag->unique(),
                'meta' => $meta,
                'opengraph' => $opengraph,
                'canonical' => $canonical,

                'category_select' => $category_select,
                'tag_select' => $tag_select,
                'tag_selection' => $tag_selection,
                'meta_select' => $meta_select,
                'opengraph_select' => $opengraph_select,
                'canonical_select' => $canonical_select,
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
    public function update(PostFormRequest $request, $id)
    {
        $request->validated();
        $post_data = $request->only(['title', 'slug', 'content', 'category', 'tag', 'meta', 'opengraph', 'canonical', 'feature_image', 'published']);

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Post)->log($request->validator->messages());
        }

        DB::beginTransaction();

        try {
            if ($request->file('feature_image')) {
                $feature_image = $this->upload->UploadFeatureImageToStorage($post_data['feature_image']);
                $post_data['feature_image'] = $feature_image;
            }

            $this->post->UpdatePost($post_data, $id);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Post)->log($this->translation->post['messages']['update_success']);
            return redirect()->route('post.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->post['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = $th->getMessage();
            report($message);

            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new Post)->log($message);
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
            $delete = $this->post->DeletePost($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Post)->log($this->translation->post['messages']['delete_success']);

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new Post)->log($message);
            return redirect()->back()->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }
}
