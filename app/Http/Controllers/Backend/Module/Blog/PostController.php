<?php

namespace App\Http\Controllers\Backend\Module\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Canonical;
use App\Models\Category;
use App\Models\MediaLibrary;
use App\Models\Meta;
use App\Models\Opengraph;
use App\Models\Post;
use App\Models\Tag;
use App\Services\BackendTranslations;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Models\Schemadata;

class PostController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $dataTables;
    protected $responseFormatter;
    protected $fileManagement;
    protected $post;
    protected $category;
    protected $tag;
    protected $meta;
    protected $opengraph;
    protected $canonical;
    protected $upload;
    protected $medialibrary;
    protected $schema;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        BackendTranslations $translation,
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
        MediaLibrary $medialibrary,
        Schemadata $schema,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->except(['store', 'update']);
        // $this->middleware(['xss-sanitize'])->only(['store', 'update']);
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
        $this->medialibrary = $medialibrary;
        $this->schema = $schema;
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
        $res = $this->dataTables->of($this->post->getPostsQueries()->orderBy('published_at', 'DESC'))
            ->addColumn('title', function ($post) {
                return $post->title;
            })
            ->addColumn('image', function ($post) {
                $imageUrl = '';
                if ($post->medialibraries->isNotEmpty()) {
                    $mediaLibrary = $post->medialibraries->first(); // Assuming one image per user
                    if ($mediaLibrary->media_files) {
                        $imageUrl = Storage::url($mediaLibrary->media_files);
                    }
                }

                return $imageUrl;
            })
            ->addColumn('publish', function ($post) {
                if ($post->published_at == null || $post->published_at == '' || $post->published_at == 'null') {
                    return '';
                }

                if ($post->published_at != null) {
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
        $schema_select = $this->schema->query()->get();

        return view('template.default.backend.module.blog.post.form', array_merge(
            $this->global_variable->PageType('create'),
            [
                'category_select' => $category_select,
                'tag_select' => $tag_select,
                'meta_select' => $meta_select,
                'opengraph_select' => $opengraph_select,
                'canonical_select' => $canonical_select,
                'schema_select' => $schema_select,
            ]
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PostFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Post())->log($request->validator->messages());
        }

        $request->validated();
        $post_data = $request->only(['title', 'slug', 'content', 'category', 'tag', 'meta', 'canonical', 'opengraph', 'schema', 'feature_image', 'published']);

        $post_data['author_id'] = Auth::user()->id;
        $media_library_ids = []; // Inisialisasi array untuk menyimpan ID MediaLibrary

        // Upload Feature Image
        if ($request->file('feature_image')) {
            $feature = $this->upload->UploadPostFeatureImageToMediaLibrary($request->file('feature_image'));

            // Simpan ke Media Library
            $media_data = [
                'title' => $request->file('feature_image')->getClientOriginalName(),
                'media-files' => $feature['media_path'],
                'information' => '',
                'description' => '',
            ];
            $media = $this->medialibrary->StoreMediaLibrary($media_data);

            // Tambahkan ID MediaLibrary ke array
            $media_library_ids[] = $media->id;

            $post_data['feature_image'] = $feature['media_path'];
        }

        // Handle Images in Content (Summernote)
        if (!empty($request->input('content'))) {
            $dom = new \DOMDocument();
            @$dom->loadHtml($request->input('content'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {
                $data = $img->getAttribute('src');

                // Gambar baru diunggah
                if (strpos($data, 'data:image') !== false) {
                    list($type, $data) = explode(';', $data);
                    list(, $data) = explode(',', $data);
                    $fileData = base64_decode($data);
                    $image_name = time().$k.'.png'; // Generate unique name

                    // Simpan ke Media Library
                    $media = $this->upload->UploadPostContentImageToMediaLibrary($fileData, $image_name);

                    $media_data = [
                        'title' => $image_name,
                        'media-files' => $media['media_path'],
                        'information' => '',
                        'description' => '',
                    ];
                    $medialibrary = $this->medialibrary->StoreMediaLibrary($media_data);
                    $media_library_ids[] = $medialibrary->id;

                    $img->removeAttribute('src');
                    $img->setAttribute('src', Storage::url($media['media_path']));
                }
            }
            $post_data['content'] = $dom->saveHTML();
        }

        // Masukkan array ID MediaLibrary ke dalam data post
        $post_data['media_library'] = $media_library_ids;
        $verified_data = Arr::except($post_data, ['feature_image']);

        $this->post->StorePost($verified_data);


        DB::beginTransaction();
        try {

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Post())->log($this->translation->post['messages']['store_success']);

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
            activity()->causedBy(Auth::user())->performedOn(new Post())->log($message);

            return redirect()->route('post.create')->with([
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
        $post = $this->post->GetPostById($id);
        $category = $post->categories()->first();
        $tag = $post->tags()->get();
        $meta = $post->metas()->first();
        $opengraph = $post->opengraphs()->first();
        $canonical = $post->canonicals()->first();
        $schema = $post->schemadatas()->first();

        $category_select = $this->category->query()->get();
        $tag_select = $this->tag->query()->get();
        $meta_select = $this->meta->query()->get();
        $opengraph_select = $this->opengraph->query()->get();
        $canonical_select = $this->canonical->query()->get();
        $schema_select = $this->schema->query()->get();
        $author = $post->author()->first();
        if ($post->published_at == null || $post->published_at == '' || $post->published_at == 'null') {
            $published = 'No';
        }

        if ($post->published_at != null) {
            $published = 'Yes';
        }

        foreach ($tag as $value) {
            $tag_selection[] = $value->id;
        }

        if (!isset($tag_selection)) {
            $tag_selection = [];
        }

        // Check if the user has a related MediaLibrary record
        if ($post->medialibraries()->exists()) {
            $image = $post->medialibraries->first()->media_files;
        } else {
            // Set a default image path if no image is found
            $image = null;
        }

        return $this->responseFormatter->successResponse([
            'post' => $post,
            'image' => $image,
            'content' => $post->content,
            'category' => $category,
            'tag' => $tag,
            'meta' => $meta,
            'canonical' => $canonical,
            'opengraph' => $opengraph,
            'schema' => $schema,
            'author' => $author,
            'published' => $published,
        ]);
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

        if (!isset($tag_selection)) {
            $tag_selection = [];
        }

        // Check if the user has a related MediaLibrary record
        if ($post->medialibraries()->exists()) {
            $image = $post->medialibraries->first()->media_files;
        } else {
            // Set a default image path if no image is found
            $image = null;
        }

        return view('template.default.backend.module.blog.post.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'post' => $post,
                'image' => $image,
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
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PostFormRequest $request, $id)
    {
        $request->validated();
        $post_data = $request->only(['title', 'slug', 'content', 'category', 'tag', 'meta', 'opengraph', 'canonical', 'feature_image', 'published']);

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Post())->log($request->validator->messages());
        }

        $media_library_ids = [];
        $post = $this->post->GetPostById($id);

        // Upload Feature Image
        if ($request->file('feature_image')) {
            // Detach gambar lama jika ada
            $post->mediaLibraries()->detach();

            $feature = $this->upload->UploadPostFeatureImageToMediaLibrary($request->file('feature_image'));

            // Simpan ke Media Library
            $media_data = [
                'title' => $request->file('feature_image')->getClientOriginalName(),
                'media-files' => $feature['media_path'],
                'information' => '',
                'description' => '',
            ];
            $media = $this->medialibrary->StoreMediaLibrary($media_data);

            // Tambahkan ID MediaLibrary ke array
            $media_library_ids[] = $media->id;

            $post_data['feature_image'] = $feature['media_path'];
        }

        // Handle Images in Content (Summernote)
        if (!empty($request->input('content'))) {
            $dom = new \DOMDocument();
            @$dom->loadHtml($request->input('content'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {
                $data = $img->getAttribute('src');

                // Gambar baru diunggah
                if (strpos($data, 'data:image') !== false) {
                    list($type, $data) = explode(';', $data);
                    list(, $data) = explode(',', $data);
                    $fileData = base64_decode($data);
                    $image_name = time().$k.'.png'; // Generate unique name

                    // Simpan ke Media Library
                    $media = $this->upload->UploadPostContentImageToMediaLibrary($fileData, $image_name);

                    $media_data = [
                        'title' => $image_name,
                        'media-files' => $media['media_path'],
                        'information' => '',
                        'description' => '',
                    ];
                    $medialibrary = $this->medialibrary->StoreMediaLibrary($media_data);
                    $media_library_ids[] = $medialibrary->id;

                    $img->removeAttribute('src');
                    $img->setAttribute('src', Storage::url($media['media_path']));
                }
            }
            $post_data['content'] = $dom->saveHTML();
        }

        // Masukkan array ID MediaLibrary ke dalam data post
        $post_data['media_library'] = $media_library_ids;
        $verified_data = Arr::except($post_data, ['feature_image']);

        DB::beginTransaction();

        try {
            $post->mediaLibraries()->attach($media_library_ids);
            $this->post->UpdatePost($verified_data, $id);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Post())->log($this->translation->post['messages']['update_success']);

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
            activity()->causedBy(Auth::user())->performedOn(new Post())->log($message);

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

            $post = $this->post->GetPostByID($id); // Ambil data postingan

            // Detach all media libraries and delete the associated files
            foreach ($post->mediaLibraries as $media) {
                Storage::delete('public/'.$media->media_files); // Hapus file dari storage
                $post->mediaLibraries()->detach($media->id); // Detach relasi
                $media->delete(); // Hapus dari tabel medialibraries
            }

            $delete = $this->post->DeletePost($id);
            DB::commit();

            // check data deleted or not
            if ($delete == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }

            activity()->causedBy(Auth::user())->performedOn(new Post())->log($this->translation->post['messages']['delete_success']);

            //  Return response
            return response()->json(['status' => $status]);
        } catch (\Throwable$th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);

            activity()->causedBy(Auth::user())->performedOn(new Post())->log($message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }
}
