<?php

namespace App\Http\Controllers\Backend\Module\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageFormRequest;
use App\Models\Canonical;
use App\Models\Layout;
use App\Models\Meta;
use App\Models\Opengraph;
use App\Models\Page;
use App\Models\Schemadata;
use App\Services\BackendTranslations;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $dataTables;
    protected $responseFormatter;
    protected $fileManagement;
    protected $page;
    protected $layout;
    protected $meta;
    protected $opengraph;
    protected $canonical;
    protected $schema;

    public function __construct(
        GlobalView $global_view,
        GlobalVariable $global_variable,
        BackendTranslations $translation,
        DataTables $dataTables,
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        Page $page,
        Layout $layout,
        Meta $meta,
        Opengraph $opengraph,
        Canonical $canonical,
        Schemadata $schema
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:template-sidebar']); // Adjust permissions as needed
        $this->middleware(['permission:page-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:page-create'])->only('create');
        $this->middleware(['permission:page-edit'])->only('edit');
        $this->middleware(['permission:page-store'])->only('store');
        $this->middleware(['permission:page-update'])->only('update');
        $this->middleware(['permission:page-destroy'])->only('destroy');
        $this->global_view = $global_view;
        $this->global_variable = $global_variable;
        $this->translation = $translation;
        $this->dataTables = $dataTables;
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->page = $page;
        $this->layout = $layout;
        $this->meta = $meta;
        $this->opengraph = $opengraph;
        $this->canonical = $canonical;
        $this->schema = $schema;
    }

    protected function boot()
    {
        return $this->global_view->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->page['title'] ?? 'Page'), // Use a translation key
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->page, // Add page translations

            // Module
            $this->global_variable->ModuleType([
                'page-home',
                'page-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'page-home-js',
                'page-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('page.index'),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.template.page.home', array_merge(
            $this->global_variable->PageType('index')
        ));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->page->getPageQuery()) // Adjust query if needed
        ->addColumn('title', function ($page) {
            return $page->title;
        })
        ->addColumn('slug', function ($page) {
            return $page->slug;
        })
            ->addColumn('action', function ($page) {
                return $page->id;
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->make('true');

        return $res;
    }

    public function create()
    {
        $this->boot();
        $layouts = $this->layout->query()->get();
        $metas = $this->meta->query()->get();
        $opengraphs = $this->opengraph->query()->get();
        $canonicals = $this->canonical->query()->get();
        $schemas = $this->schema->query()->get();

        return view('template.default.backend.module.template.page.form', array_merge( // Adjust view path
            $this->global_variable->PageType('create'),
            [
                'layouts' => $layouts,
                'metas' => $metas,
                'opengraphs' => $opengraphs,
                'canonicals' => $canonicals,
                'schemas' => $schemas,
            ]
        ));
    }

    public function store(PageFormRequest $request)
    {
        $request->validated();
        $data = $request->only([
            'title', 'slug', 'content', 'layout_id', 'meta_id', 'opengraph_id', 'canonical_id', 'schemadata_id',
        ]);

        DB::beginTransaction();
        try {
            $this->page->StorePage($data);
            DB::commit();

            activity()->causedBy(Auth::user())->performedOn(new Page())->log($this->translation->page['messages']['store_success']);

            return redirect()->route('page.index')->with([
                'success' => 'success',
                'title' => 'Success',
                'content' => $this->translation->page['messages']['store_success'],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Page())->log('Error creating page: '.$e->getMessage());

            return redirect()->route('page.index')->with([
                'error' => 'error',
                'title' => 'Error',
                'content' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $this->boot();
        $page = $this->page->findOrFail($id);
        $layouts = $this->layout->query()->get();
        $metas = $this->meta->query()->get();
        $opengraphs = $this->opengraph->query()->get();
        $canonicals = $this->canonical->query()->get();
        $schemas = $this->schema->query()->get();

        return view('template.default.backend.module.template.page.form', array_merge( // Adjust view path
            $this->global_variable->PageType('edit'),
            [
                'page' => $page,
                'layouts' => $layouts,
                'metas' => $metas,
                'opengraphs' => $opengraphs,
                'canonicals' => $canonicals,
                'schemas' => $schemas,
            ]
        ));
    }

    public function update(PageFormRequest $request, $id)
    {
        $request->validated();
        $data = $request->only([
            'title', 'slug', 'content', 'layout_id', 'meta_id', 'opengraph_id', 'canonical_id', 'schemadata_id',
        ]);

        DB::beginTransaction();
        try {
            $page = $this->page->findOrFail($id);
            $page->update($data);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Page())->log($this->translation->page['messages']['update_success']);

            return redirect()->route('page.index')->with([
                'success' => 'success',
                'title' => 'Success',
                'content' => $this->translation->page['messages']['update_success'],
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Page())->log('Error creating page: '.$e->getMessage());

            return redirect()->route('page.index')->with([
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
            $this->page->DeletePage($id);
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Page())->log($this->translation->page['messages']['delete_success']);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Page())->log('Error deleting page: '.$e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
