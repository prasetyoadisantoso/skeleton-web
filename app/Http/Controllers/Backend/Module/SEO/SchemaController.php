<?php

namespace App\Http\Controllers\Backend\Module\SEO;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchemaFormRequest; // Create this request later
use App\Models\Post;
use App\Models\Schemadata;
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SchemaController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $dataTables;
    protected $responseFormatter;
    protected $schema;
    protected $post;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        BackendTranslations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        Schemadata $schema,
        Post $post // Inject Post model if needed
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->except(['store', 'update']);
        $this->middleware(['permission:blog-sidebar']); // Adjust permissions as needed
        $this->middleware(['permission:schema-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:schema-create'])->only('create');
        $this->middleware(['permission:schema-edit'])->only('edit');
        $this->middleware(['permission:schema-store'])->only('store');
        $this->middleware(['permission:schema-update'])->only('update');
        $this->middleware(['permission:schema-destroy'])->only('destroy');

        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->schema = $schema;
        $this->post = $post; // Assign Post model
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->schema['title'] ?? 'Schemas'), // Use a translation key
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->schema, // Add schema translations

            // Module
            $this->global_variable->ModuleType([
                'schema-home',
                'schema-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'schema-home-js',
                'schema-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('schema.index'),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.seo.schema.home', array_merge( // Adjust view path
            $this->global_variable->PageType('index')
        ));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->schema->query()) // Adjust query if needed
            ->addColumn('schema_name', function ($schema) {
                return $schema->schema_name;
            })
            ->addColumn('schema_type', function ($schema) {
                return $schema->schema_type;
            })
            ->addColumn('schema_content', function ($schema) {
                $escapedContent = json_encode($schema->schema_content, JSON_UNESCAPED_UNICODE);

                return $escapedContent;
            })
            ->addColumn('action', function ($schema) {
                return $schema->id;
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->make('true');

        return $res;
    }

    public function create()
    {
        $this->boot();
        $posts = $this->post->query()->get(); // Get all posts for selection

        return view('template.default.backend.module.seo.schema.form', array_merge( // Adjust view path
            $this->global_variable->PageType('create'),
            ['posts' => $posts] // Pass posts to the view
        ));
    }

    public function store(SchemaFormRequest $request)
    {
        $request->validated();

        $data = $request->only(['schema_name', 'schema_type', 'schema_content']); // Include 'posts'

        DB::beginTransaction();
        try {
            $schema = $this->schema->create($data);

            // Attach the schema to the selected posts
            if (isset($data['posts']) && is_array($data['posts'])) {
                $schema->posts()->attach($data['posts']);
            }

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Schemadata())->log('Schema created successfully.');

            return redirect()->route('schema.index')->with([
                'success' => 'success',
                'title' => 'Success',
                'content' => 'Schema created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Schemadata())->log('Error creating schema: '.$e->getMessage());

            return redirect()->route('schema.create')->with([
                'error' => 'error',
                'title' => 'Error',
                'content' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        $schema = $this->schema->findOrFail($id);

        return $this->responseFormatter->successResponse(['schema' => $schema]);
    }

    public function edit($id)
    {
        $this->boot();
        $schema = $this->schema->findOrFail($id);
        $posts = $this->post->query()->get(); // Get all posts for selection

        return view('template.default.backend.module.seo.schema.form', array_merge( // Adjust view path
            $this->global_variable->PageType('edit'),
            [
                'schema' => $schema,
                'posts' => $posts,
                'selectedPosts' => $schema->posts()->pluck('id')->toArray(), // Get selected posts
            ]
        ));
    }

    public function update(SchemaFormRequest $request, $id)
    {
        $request->validated();

        $data = $request->only(['schema_name', 'schema_type', 'schema_content']);

        $schema = $this->schema->findOrFail($id);

        DB::beginTransaction();
        try {
            $schema->update($data);

            // Sync the schema to the selected posts
            if (isset($data['posts']) && is_array($data['posts'])) {
                $schema->posts()->sync($data['posts']);
            } else {
                $schema->posts()->detach(); // Detach all posts if none selected
            }

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Schemadata())->log('Schema updated successfully.');

            return redirect()->route('schema.index')->with([
                'success' => 'success',
                'title' => 'Success',
                'content' => 'Schema updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Schemadata())->log('Error updating schema: '.$e->getMessage());

            return redirect()->route('schema.edit', $id)->with([
                'error' => 'error',
                'title' => 'Error',
                'content' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $schema = $this->schema->findOrFail($id);
            $schema->posts()->detach(); // Detach from posts before deleting
            $schema->delete();

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Schemadata())->log('Schema deleted successfully.');

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Schemadata())->log('Error deleting schema: '.$e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
