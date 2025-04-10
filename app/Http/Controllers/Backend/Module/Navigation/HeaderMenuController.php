<?php

namespace App\Http\Controllers\Backend\Module\Navigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderMenuFormRequest;
use App\Models\Headermenu;
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class HeaderMenuController extends Controller
{
    protected $backendtranslations;
    protected $globalview;
    protected $global_variable;
    protected $dataTables;
    protected $headerMenu;

    public function __construct(
        Headermenu $headerMenu,
        BackendTranslations $backendTranslations,
        GlobalView $globalView,
        GlobalVariable $global_variable,
        DataTables $dataTables,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->except(['store', 'update']);
        $this->middleware(['permission:navigation-sidebar']); // Adjust permissions as needed
        $this->middleware(['permission:headermenu-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:headermenu-create'])->only('create');
        $this->middleware(['permission:headermenu-edit'])->only('edit');
        $this->middleware(['permission:headermenu-store'])->only('store');
        $this->middleware(['permission:headermenu-update'])->only('update');
        $this->middleware(['permission:headermenu-destroy'])->only('destroy');

        $this->backendtranslations = $backendTranslations;
        $this->globalview = $globalView;
        $this->global_variable = $global_variable;
        $this->dataTables = $dataTables;
        $this->headerMenu = $headerMenu;
    }

    protected function boot()
    {
        $this->globalview->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->headermenu['title'] ?? 'Header Menu'), // Use a translation key
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translation
            $this->backendtranslations->header_menu,

            // Module
            $this->global_variable->ModuleType([
                'headermenu-home',
                'headermenu-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'headermenu-home-js',
                'headermenu-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('headermenu.index'),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.navigation.header.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->headerMenu->query()->with(['parent'])) // Adjust query if needed
            ->addColumn('name', function ($headerMenu) {
                return $headerMenu->name;
            })
            ->addColumn('label', function ($headerMenu) {
                return $headerMenu->label;
            })
            ->addColumn('url', function ($headerMenu) {
                return $headerMenu->url;
            })
            ->addColumn('parent', function ($headerMenu) {
                if ($headerMenu->parent_id) {
                    // Ambil data parent menggunakan cara lama (tidak disarankan)
                    $parent = $this->headerMenu->getHeaderMenuById($headerMenu->parent_id);

                    if ($parent) {
                        // Decode JSON jika perlu
                        $dataparent = json_decode($parent);

                        return $dataparent->name; // Ambil nama
                    } else {
                        return 'Parent Not Found';
                    }
                } else {
                    return 'No Parent';
                }
            })
            ->addColumn('order', function ($headerMenu) {
                return $headerMenu->order;
            })
            ->addColumn('target', function ($headerMenu) {
                return $headerMenu->target;
            })
            ->addColumn('status', function ($headerMenu) {
                $data = $headerMenu->is_active;
                if ($data == 1) {
                    $res = 'Active';
                } else {
                    $res = 'Inactive';
                }

                return $res;
            })
            ->addColumn('action', function ($headerMenu) {
                return $headerMenu->id;
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->make('true');

        return $res;
    }

    public function create()
    {
        $this->boot();
        $menus = Headermenu::orderBy('order')->get();

        return view('template.default.backend.module.navigation.header.form', array_merge(
            $this->global_variable->PageType('create'),
            ['menus' => $menus]
        ));
    }

    public function store(HeaderMenuFormRequest $request)
    {
        $request->validated();
        $data = $request->only(['name', 'label', 'url', 'icon', 'parent_id', 'order', 'target', 'is_active']);

        DB::beginTransaction();
        try {
            $this->headerMenu->StoreHeaderMenu($data);

            DB::commit();

            activity()->causedBy(Auth::user())->performedOn(new Headermenu())->log('Header Menu created successfully.');

            return redirect()->route('headermenu.index')->with([
                'success' => 'success',
                'title' => 'Success',
                'content' => 'headermenu created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Headermenu())->log('Error creating Header Menu: '.$e->getMessage());

            return redirect()->route('headermenu.create')->with([
                'error' => 'error',
                'title' => 'Error',
                'content' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $this->boot();
        $menu = Headermenu::findOrFail($id);
        $menus = Headermenu::orderBy('order')->get();

        return view('template.default.backend.module.navigation.header.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'menu' => $menu,
                'menus' => $menus,
            ]
        ));
    }

    public function update(HeaderMenuFormRequest $request, $id)
    {
        $request->validated();
        $data = $request->only(['name', 'label', 'url', 'icon', 'parent_id', 'order', 'target', 'is_active']);

        DB::beginTransaction();
        try {
            $this->headerMenu->UpdateHeaderMenu($data, $id);

            DB::commit();

            activity()->causedBy(Auth::user())->performedOn(new Headermenu())->log(' Menu created successfully.');

            return redirect()->route('headermenu.index')->with([
                'success' => 'success',
                'title' => 'Success',
                'content' => 'headermenu created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Headermenu())->log('Error creating Menu: '.$e->getMessage());

            return redirect()->route('headermenu.create')->with([
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
            $this->headerMenu->DeleteHeaderMenu($id);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Headermenu())->log('Menu deleted successfully.');

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Headermenu())->log('Error deleting Menu: '.$e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
