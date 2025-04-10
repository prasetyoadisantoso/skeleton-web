<?php

namespace App\Http\Controllers\Backend\Module\Navigation;

use App\Http\Controllers\Controller;
use App\Http\Requests\FooterMenuFormRequest;
use App\Models\Footermenu;
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FooterMenuController extends Controller
{
    protected $backendtranslations;
    protected $globalview;
    protected $global_variable;
    protected $dataTables;
    protected $footerMenu;

    public function __construct(
        Footermenu $footerMenu,
        BackendTranslations $backendTranslations,
        GlobalView $globalView,
        GlobalVariable $global_variable,
        DataTables $dataTables,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->except(['store', 'update']);
        $this->middleware(['permission:navigation-sidebar']); // Adjust permissions as needed
        $this->middleware(['permission:footermenu-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:footermenu-create'])->only('create');
        $this->middleware(['permission:footermenu-edit'])->only('edit');
        $this->middleware(['permission:footermenu-store'])->only('store');
        $this->middleware(['permission:footermenu-update'])->only('update');
        $this->middleware(['permission:footermenu-destroy'])->only('destroy');

        $this->backendtranslations = $backendTranslations;
        $this->globalview = $globalView;
        $this->global_variable = $global_variable;
        $this->dataTables = $dataTables;
        $this->footerMenu = $footerMenu;
    }

    protected function boot()
    {
        $this->globalview->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->backendtranslations->footer_menu['title'] ?? 'Footer Menu'), // Use a translation key
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translation
            $this->backendtranslations->footer_menu,

            // Module
            $this->global_variable->ModuleType([
                'footermenu-home',
                'footermenu-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'footermenu-home-js',
                'footermenu-form-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('footermenu.index'),
        ]);
    }

    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.navigation.footer.home', array_merge(
            $this->global_variable->PageType('index'),
        ));
    }

    public function index_dt()
    {
        $res = $this->dataTables->of($this->footerMenu->query()) // Adjust query if needed
            ->addColumn('name', function ($footerMenu) {
                return $footerMenu->name;
            })
            ->addColumn('label', function ($footerMenu) {
                return $footerMenu->label;
            })
            ->addColumn('url', function ($footerMenu) {
                return $footerMenu->url;
            })
            ->addColumn('order', function ($footerMenu) {
                return $footerMenu->order;
            })
            ->addColumn('target', function ($footerMenu) {
                return $footerMenu->target;
            })
            ->addColumn('status', function ($footerMenu) {
                $data = $footerMenu->is_active;
                if ($data == 1) {
                    $res = 'Active';
                } else {
                    $res = 'Inactive';
                }

                return $res;
            })
            ->addColumn('action', function ($footerMenu) {
                return $footerMenu->id;
            })
            ->removeColumn('id')
            ->addIndexColumn()
            ->make('true');

        return $res;
    }

    public function create()
    {
        $this->boot();
        $menus = Footermenu::orderBy('order')->get();

        return view('template.default.backend.module.navigation.footer.form', array_merge(
            $this->global_variable->PageType('create'),
            ['menus' => $menus]
        ));
    }

    public function store(FooterMenuFormRequest $request)
    {
        $request->validated();
        $data = $request->only(['name', 'label', 'url', 'icon', 'order', 'target', 'is_active']);

        DB::beginTransaction();
        try {
            $this->footerMenu->StoreFooterMenu($data);

            DB::commit();

            activity()->causedBy(Auth::user())->performedOn(new Footermenu())->log('Footer Menu created successfully.');

            return redirect()->route('footermenu.index')->with([
                'success' => $this->backendtranslations->notification['store']['success'] ?? 'success',
                'title' => $this->backendtranslations->notification['store']['title'] ?? 'Success',
                'content' => $this->backendtranslations->notification['store']['content'] ?? 'Data created successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Footermenu())->log('Error creating Footer Menu: '.$e->getMessage());

            return redirect()->route('footermenu.create')->with([
                'error' => 'error',
                'title' => 'Error',
                'content' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $this->boot();
        $menu = Footermenu::findOrFail($id);
        $menus = Footermenu::orderBy('order')->get();

        return view('template.default.backend.module.navigation.footer.form', array_merge(
            $this->global_variable->PageType('edit'),
            [
                'menu' => $menu,
                'menus' => $menus,
            ]
        ));
    }

    public function update(FooterMenuFormRequest $request, $id)
    {
        $request->validated();
        $data = $request->only(['name', 'label', 'url', 'icon', 'order', 'target', 'is_active']);

        DB::beginTransaction();
        try {
            $this->footerMenu->UpdateFooterMenu($data, $id);

            DB::commit();

            activity()->causedBy(Auth::user())->performedOn(new Footermenu())->log(' Menu created successfully.');

            return redirect()->route('footermenu.index')->with([
                'success' => $this->backendtranslations->notification['update']['success'] ?? 'success',
                'title' => $this->backendtranslations->notification['update']['title'] ?? 'Success',
                'content' => $this->backendtranslations->notification['update']['content'] ?? 'Data updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Footermenu())->log('Error creating Menu: '.$e->getMessage());

            return redirect()->route('footermenu.create')->with([
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
            $this->footerMenu->DeleteFooterMenu($id);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Footermenu())->log('Menu deleted successfully.');

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            activity()->causedBy(Auth::user())->performedOn(new Footermenu())->log('Error deleting Menu: '.$e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
