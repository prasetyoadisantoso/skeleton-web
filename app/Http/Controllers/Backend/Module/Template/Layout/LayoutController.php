<?php

namespace App\Http\Controllers\Backend\Module\Template\Layout;

use App\Http\Controllers\Controller;
use App\Http\Requests\LayoutFormRequest; // Pastikan ini namespace yang benar
use App\Models\Layout;
use App\Models\Section;
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables; // <-- Import Request jika belum ada

class LayoutController extends Controller
{
    protected $global_variable;
    protected $global_view;
    protected $dataTables;
    protected $translation;
    protected $layout;

    /**
     * Constructor: Inject dependencies.
     */
    public function __construct(
        Layout $layout,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        DataTables $dataTables,
        BackendTranslations $translation
    ) {
        // Apply middleware
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->only(['store', 'update']);

        // Permission middleware (TEMPLATE SIDEBAR ACCESS HARUS ADA)
        $this->middleware(['permission:template-sidebar']);
        $this->middleware(['permission:layout-index'])->only(['index', 'datatable']);
        $this->middleware(['permission:layout-create'])->only('create');
        $this->middleware(['permission:layout-edit'])->only('edit');
        $this->middleware(['permission:layout-store'])->only('store');
        $this->middleware(['permission:layout-update'])->only('update');
        $this->middleware(['permission:layout-destroy'])->only(['destroy', 'bulkDestroy']);

        // Assign injected dependencies
        $this->layout = $layout;
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->dataTables = $dataTables;
        $this->translation = $translation;
    }

    /**
     * Prepare global view variables.
     */
    protected function boot()
    {
        $this->global_view->RenderView([
            $this->global_variable->TitlePage($this->translation->layout['title'] ?? 'Layouts'),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            $this->translation->layout,

            $this->global_variable->ModuleType([
                'layout-home',
                'layout-form',
            ]),

            $this->global_variable->ScriptType([
                'layout-home-js',
                'layout-form-js',
                'sortable-js', // Pastikan Sortable JS ter-load
            ]),

            $this->global_variable->RouteType('layout.index'),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->boot();

        // Render view
        return view('template.default.backend.module.template.layout.home',
            array_merge($this->global_variable->PageType('index'))
        );
    }

    /**
     * Generate datatable data.
     */
    public function index_dt()
    {
        $query = $this->layout->query()->orderBy('created_at', 'DESC');

        return $this->dataTables->of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($layout) {
                return $layout->id;
            })
            ->rawColumns([])
            ->make(true);
    }

    public function create()
    {
        $this->boot(); // Panggil boot untuk menyiapkan global view

        $sections = Section::orderBy('name')->get(); // Ambil semua section yang tersedia
        $type = 'create';

        // Data untuk form create (tidak ada layout yang dipilih)
        $layoutData = null; // Atau new Layout() jika perlu properti default

        // --- DEFINISIKAN VARIABEL YANG DIBUTUHKAN VIEW ---
        $mainSectionsCollection = collect(); // Collection kosong
        $sidebarSectionsCollection = collect(); // Collection kosong
        $selectedMainIds = collect(); // Collection ID kosong (diperlukan untuk @unless)
        $selectedSidebarIds = collect(); // Collection ID kosong (diperlukan untuk @unless)
        $mainSectionOrders = []; // Array order kosong
        $sidebarSectionOrders = []; // Array order kosong
        // ------------------------------------------------

        // Variabel $breadcrumb, $form, $button sudah tersedia dari boot()

        // Kirim semua variabel yang dibutuhkan ke view
        return view('template.default.backend.module.template.layout.form',
            array_merge(
                compact(
                    'type',
                    'layoutData',
                    'sections',
                    'mainSectionsCollection', // <-- KIRIM INI
                    'sidebarSectionsCollection', // <-- KIRIM INI
                    'selectedMainIds',        // <-- KIRIM INI
                    'selectedSidebarIds',       // <-- KIRIM INI
                    'mainSectionOrders',      // <-- KIRIM INI
                    'sidebarSectionOrders'     // <-- KIRIM INI
                ),
                $this->global_variable->PageType('create') // Tambahkan tipe halaman
            )
        );
    }

    public function store(LayoutFormRequest $request)
    {
        // Sudah divalidasi oleh LayoutFormRequest
        $validatedData = $request->validated();

        // Pengaman tambahan, meskipun withValidator seharusnya sudah handle
        if ($validatedData['type'] === 'full-width') {
            unset($validatedData['sections_sidebar']);
        }

        DB::beginTransaction();
        try {
            // Buat layout baru
            $layout = Layout::create($validatedData);

            // Attach sections ke layout (main)
            if (isset($validatedData['sections_main']) && is_array($validatedData['sections_main'])) {
                foreach ($validatedData['sections_main'] as $sectionId => $sectionData) {
                    // Pastikan $sectionData['id'] memang ada (validasi backend)
                    if (isset($sectionData['id'])) {
                        // Pastikan order valid
                        $order = isset($sectionData['order']) && is_numeric($sectionData['order']) ? intval($sectionData['order']) : 0;
                        $layout->sectionsMain()->attach($sectionData['id'], ['location' => 'main', 'order' => $order]);
                    }
                }
            }

            // Attach sections ke layout (sidebar)
            // Hanya jika type === 'sidebar' dan sections_sidebar ada
            if (isset($validatedData['type']) && $validatedData['type'] === 'sidebar' && isset($validatedData['sections_sidebar']) && is_array($validatedData['sections_sidebar'])) {
                foreach ($validatedData['sections_sidebar'] as $sectionId => $sectionData) {
                    // Pastikan $sectionData['id'] memang ada (validasi backend)
                    if (isset($sectionData['id'])) {
                        // Pastikan order valid
                        $order = isset($sectionData['order']) && is_numeric($sectionData['order']) ? intval($sectionData['order']) : 0;
                        $layout->sectionsSidebar()->attach($sectionData['id'], ['location' => 'sidebar', 'order' => $order]);
                    }
                }
            }

            DB::commit(); // Commit the transaction

            // Logging activity
            activity()->causedBy(Auth::user())->performedOn($layout)->log('Layout created');

            // Redirect dengan pesan sukses
            return redirect()->route('layout.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'] ?? 'Success',
                'content' => $this->translation->layout['messages']['store_success'] ?? 'Layout created successfully.',
            ]);
        } catch (\Throwable $th) {
            // Rollback transaction jika ada error
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Layout Store Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn(new Layout())->log('Store failed: '.$message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'] ?? 'Error',
                'content' => ($this->translation->layout['messages']['store_failed'] ?? 'Failed to create layout.').': '.$message,
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Layout $layout)
    {
        return redirect()->route('layout.edit', $layout->id);
    }

    // In app/Http/Controllers/.../LayoutController.php -> edit() method
    public function edit(Layout $layout)
    {
        $this->boot();

        // Eager Loading (sudah benar, mengurutkan berdasarkan layout_section.order)
        $layout->load(['sections' => function ($query) {
            $query->withPivot('order', 'location')
                  ->orderBy('layout_section.order'); // <-- Ini mengurutkan relasi saat diambil
        }]);

        $sections = Section::orderBy('name')->get(); // Semua section (untuk loop kedua)
        $type = 'edit';
        $layoutData = $layout;

        // Proses data relasi
        $allRelatedSections = $layout->sections; // Collection section terkait, sudah terurut

        // Filter berdasarkan 'location'
        $mainSectionsCollection = $allRelatedSections->filter(function ($section) { // <-- Collection terurut untuk Main
            return $section->pivot->location === 'main';
        });
        $sidebarSectionsCollection = $allRelatedSections->filter(function ($section) { // <-- Collection terurut untuk Sidebar
            return $section->pivot->location === 'sidebar';
        });

        // Ambil IDs (untuk loop kedua di Blade)
        $selectedMainIds = $mainSectionsCollection->pluck('id');
        $selectedSidebarIds = $sidebarSectionsCollection->pluck('id');

        // Ambil order (untuk nilai awal hidden input)
        $mainSectionOrders = $mainSectionsCollection->pluck('pivot.order', 'id')->all();
        $sidebarSectionOrders = $sidebarSectionsCollection->pluck('pivot.order', 'id')->all();

        // Kirim SEMUA variabel yang dibutuhkan, termasuk collection terurut
        return view('template.default.backend.module.template.layout.form',
            array_merge(
                compact(
                    'type',
                    'layoutData',
                    'sections', // Semua section
                    'mainSectionsCollection', // <-- KIRIM INI
                    'sidebarSectionsCollection', // <-- KIRIM INI
                    'selectedMainIds',
                    'selectedSidebarIds',
                    'mainSectionOrders',
                    'sidebarSectionOrders'
                ),
                $this->global_variable->PageType('edit')
            )
        );
    }

    public function update(LayoutFormRequest $request, Layout $layout)
    {
        $validatedData = $request->validated(); // Validasi menggunakan Form Request

        DB::beginTransaction(); // Mulai transaksi database
        try {
            // Update layout information
            $layout->update($validatedData);

            // Clear existing section relationships
            $layout->sectionsMain()->detach();
            $layout->sectionsSidebar()->detach();

            // Attach Main Sections
            if (isset($validatedData['sections_main']) && is_array($validatedData['sections_main'])) {
                foreach ($validatedData['sections_main'] as $sectionId => $sectionData) {
                    if (isset($sectionData['id'])) {
                        $order = isset($sectionData['order']) && is_numeric($sectionData['order']) ? intval($sectionData['order']) : 0;
                        $layout->sectionsMain()->attach($sectionData['id'], ['location' => 'main', 'order' => $order]);
                    }
                }
            }

            // Attach Sidebar Sections
            if (isset($validatedData['type']) && $validatedData['type'] === 'sidebar' && isset($validatedData['sections_sidebar']) && is_array($validatedData['sections_sidebar'])) {
                foreach ($validatedData['sections_sidebar'] as $sectionId => $sectionData) {
                    if (isset($sectionData['id'])) {
                        $order = isset($sectionData['order']) && is_numeric($sectionData['order']) ? intval($sectionData['order']) : 0;
                        $layout->sectionsSidebar()->attach($sectionData['id'], ['location' => 'sidebar', 'order' => $order]);
                    }
                }
            }

            DB::commit(); // Commit transaction

            // Dispatch activity log event
            activity()->causedBy(Auth::user())->performedOn($layout)->log('Layout updated');

            // Set success message and redirect
            return redirect()->route('layout.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'] ?? 'Success',
                'content' => $this->translation->layout['messages']['update_success'] ?? 'Layout updated successfully.',
            ]);
        } catch (\Throwable $th) {
            // Rollback transaction if any error occurred
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Layout Update Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn($layout)->log('Update failed: '.$message);

            return redirect()->back()->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'] ?? 'Error',
                'content' => ($this->translation->layout['messages']['update_failed'] ?? 'Failed to update layout.').': '.$message,
            ])->withInput(); // Mengirim kembali input yang sudah diisi untuk perbaikan
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layout $layout)
    {
        DB::beginTransaction();
        try {
            // Detach all sections
            $layout->sectionsMain()->detach(); // Hapus relasi main
            $layout->sectionsSidebar()->detach(); // Hapus relasi sidebar

            $layout->delete(); // Delete layout

            DB::commit();

            // Log activity
            activity()->causedBy(Auth::user())->performedOn($layout)->log('Layout deleted');

            return response()->json([
                'status' => 'success',
                'message' => $this->translation->layout['messages']['delete_success'] ?? 'Layout deleted successfully.',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Layout Delete Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn($layout)->log('Delete failed: '.$message);

            return response()->json([
                'status' => 'error',
                'message' => ($this->translation->layout['messages']['delete_failed'] ?? 'Failed to delete layout.').': '.$message,
            ], 500);
        }
    }

    /**
     * Bulk delete function.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids'); // Ambil array ids

        DB::beginTransaction();
        try {
            Layout::whereIn('id', $ids)->each(function ($layout) {
                $layout->sectionsMain()->detach(); // Hapus relasi main
                $layout->sectionsSidebar()->detach(); // Hapus relasi sidebar
                $layout->delete(); // Delete layout
            });

            DB::commit();

            // Log activity
            activity()->causedBy(Auth::user())->performedOn(new Layout())->log('Bulk delete layouts');

            return response()->json([
                'status' => 'success',
                'message' => 'Layouts deleted successfully.',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Bulk Layout Delete Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn(new Layout())->log('Bulk delete failed: '.$message);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete layouts.',
            ], 500);
        }
    }
}
