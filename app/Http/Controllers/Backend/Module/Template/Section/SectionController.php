<?php

namespace App\Http\Controllers\Backend\Module\Template\Section; // Sesuaikan namespace jika perlu

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionFormRequest; // <-- PERBAIKAN: Menggunakan SectionFormRequest
use App\Models\Component; // Import model Component untuk form
use App\Models\Section; // Import model Section
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Http\Request; // Gunakan Request biasa untuk datatable
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB
// Hapus Gate jika tidak digunakan secara eksplisit
// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // <-- Tambahkan use Str
use Yajra\DataTables\DataTables; // Import DataTables

class SectionController extends Controller
{
    protected $global_variable;
    protected $global_view;
    protected $dataTables;
    protected $translation;
    protected $section; // Inject model Section
    protected $component; // Inject model Component

    public function __construct(
        Section $section, // Inject model Section
        Component $component, // Inject model Component
        GlobalVariable $global_variable,
        GlobalView $global_view,
        DataTables $dataTables,
        BackendTranslations $translation
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->only(['store', 'update']);
        // Sesuaikan nama permission
        $this->middleware(['permission:template-sidebar']); // Akses ke grup menu template
        $this->middleware(['permission:section-index'])->only(['index', 'datatable']);
        $this->middleware(['permission:section-create'])->only('create');
        $this->middleware(['permission:section-edit'])->only('edit');
        $this->middleware(['permission:section-store'])->only('store');
        $this->middleware(['permission:section-update'])->only('update');
        $this->middleware(['permission:section-destroy'])->only(['destroy', 'bulkDestroy']);

        $this->section = $section; // Assign model Section
        $this->component = $component; // Assign model Component
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->dataTables = $dataTables;
        $this->translation = $translation;
    }

    /**
     * Setup global variables and translations for views.
     */
    protected function boot()
    {
        // Share global variables and translations
        $this->global_view->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->section['title'] ?? 'Sections'),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations (Gunakan key 'section' dari BackendTranslations)
            // Pastikan key 'section', 'button', 'notification' ada di BackendTranslations
            $this->translation->section,

            // Module Type (Sesuaikan dengan JS Anda)
            $this->global_variable->ModuleType([
                'section-home',
                'section-form',
            ]),

            // Script Type (Sesuaikan dengan JS Anda)
            $this->global_variable->ScriptType([
                'section-home-js',
                'section-form-js',
                'sortable-js', // Pastikan library sortable di-load jika diperlukan
            ]),

            // Route Type (Gunakan nama route index)
            $this->global_variable->RouteType('section.index'),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->boot();

        // Pastikan path view benar
        return view('template.default.backend.module.template.section.home',
            array_merge($this->global_variable->PageType('index'))
        );
    }

    /**
     * Process datatables ajax request.
     * Menggunakan helper query dari model.
     */
    public function index_dt() // Nama method konsisten: datatable
    {
        // Gunakan method helper dari model Section
        $query = $this->section->getSectionsQuery()->orderBy('created_at', 'DESC'); // Urutkan berdasarkan terbaru

        return $this->dataTables->of($query)
            ->addIndexColumn() // Tambahkan nomor urut
            ->editColumn('description', function ($section) {
                // Limit deskripsi dan strip HTML tags
                return Str::limit(strip_tags($section->description), 50); // Gunakan use Str
            })
            ->editColumn('is_active', function ($section) {
                // Kembalikan array untuk diproses JS (konsisten dengan ComponentController)
                $isActive = (bool) $section->is_active;
                $badgeClass = $isActive ? 'bg-success' : 'bg-danger';
                // Ambil teks status dari translation dengan fallback
                $statusText = $isActive
                    ? ($this->translation->section['datatable']['status_active'] ?? 'Active')
                    : ($this->translation->section['datatable']['status_inactive'] ?? 'Inactive');

                return [
                    'text' => $statusText,
                    'class' => $badgeClass,
                    'active' => $isActive,
                ];
            })
            ->addColumn('action', function ($section) {
                // Kembalikan HANYA ID untuk diproses JS (konsisten)
                return $section->id;
            })
            // Definisikan kolom mana yang berisi HTML mentah atau perlu diproses khusus di JS
            // 'is_active' tidak perlu raw karena kita kirim array
            // 'action' tidak perlu raw karena kita kirim ID saja
            ->rawColumns([]) // Kosongkan jika tidak ada HTML mentah
            ->make(true);
    }

    /**
     * Helper function to generate column layout options.
     */
    private function getColumnLayoutOptions(): array
    {
        $options = [];
        for ($i = 1; $i <= 12; ++$i) {
            $key = $i.'-column';
            // Ambil teks dari translasi jika ada, jika tidak buat default
            $text = $this->translation->section['layout_types'][$key] ?? ($i.($i === 1 ? ' Column' : ' Columns'));
            $options[$key] = $text;
        }

        return $options;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->boot();

        // Ambil data yang dibutuhkan form (mirip ComponentController)
        $availableComponents = $this->component->getComponentsQuery()
                                    ->where('is_active', true) // Hanya komponen aktif
                                    ->orderBy('name', 'asc')
                                    ->get(['id', 'name']); // Ambil ID dan Nama

        // Ambil opsi layout kolom dari helper function
        $columnLayouts = $this->getColumnLayoutOptions();

        // Data untuk form (mirip ComponentController)
        $formData = [
            'sectionData' => null, // Data section kosong untuk create
            'availableComponents' => $availableComponents,
            'selectedComponents' => collect(), // Collection kosong untuk komponen terpilih
            'initialComponentOrderJson' => '[]', // JSON order kosong
        ];

        // Pastikan path view benar
        return view('template.default.backend.module.template.section.form',
            array_merge(
                $this->global_variable->PageType('create'),
                $formData,
                ['columnLayouts' => $columnLayouts] // Kirim layout types
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * Menggunakan method helper dari model Section.
     */
    public function store(SectionFormRequest $request) // <-- PERBAIKAN: Gunakan SectionFormRequest
    {
        $validatedData = $request->validated();

        // Handle checkbox 'is_active' sudah dilakukan di SectionFormRequest->prepareForValidation()
        // Decode JSON 'components_order' sudah dilakukan di SectionFormRequest->prepareForValidation()

        // Logging validasi (opsional, konsisten dengan ComponentController)
        if (isset($request->validator) && $request->validator->fails()) {
            // Log pada instance baru karena belum ada ID
            activity()->causedBy(Auth::user())->performedOn(new Section())->log('Validation failed: '.$request->validator->messages()->toJson());
        }

        DB::beginTransaction();
        try {
            // Panggil method helper dari model Section
            // $validatedData sudah berisi 'is_active' (boolean) dan 'components_order' (array)
            $section = $this->section->storeSection($validatedData);

            DB::commit();
            // Log pada instance yang baru dibuat
            activity()->causedBy(Auth::user())->performedOn($section)->log($this->translation->section['messages']['store_success'] ?? 'Section created');

            return redirect()->route('section.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'] ?? 'Success',
                'content' => $this->translation->section['messages']['store_success'] ?? 'Section created successfully.',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($th); // Report exception untuk logging system Laravel
            Log::error('Section Store Error: '.$message.' Trace: '.$th->getTraceAsString());
            // Log pada instance baru
            activity()->causedBy(Auth::user())->performedOn(new Section())->log('Store failed: '.$message);

            return redirect()->back()->with([ // Gunakan redirect()->back() agar input tetap ada
                'error' => 'error',
                'title' => $this->translation->notification['error'] ?? 'Error',
                // Tampilkan pesan error yang lebih deskriptif jika memungkinkan
                'content' => ($this->translation->section['messages']['store_failed'] ?? 'Failed to create section.').': '.$message,
            ])->withInput(); // Sertakan input sebelumnya
        }
    }

    /**
     * Display the specified resource. (Redirect ke edit).
     */
    public function show(Section $section)
    {
        return redirect()->route('section.edit', $section->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section) // Gunakan model binding
    {
        $this->boot();

        // Gunakan method helper dari model Section untuk mengambil data dengan relasi
        // Eager load 'components' sudah ada di getSectionById
        $sectionData = $this->section->getSectionById($section->id);

        // Handle jika section tidak ditemukan (meskipun model binding biasanya sudah handle)
        if (!$sectionData) {
            return redirect()->route('section.index')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'] ?? 'Error',
                'content' => $this->translation->section['messages']['not_found'] ?? 'Section not found.',
            ]);
        }

        // Ambil data lain yang dibutuhkan form (mirip ComponentController)
        $availableComponents = $this->component->getComponentsQuery()
                                    ->where('is_active', true)
                                    ->orderBy('name', 'asc')
                                    ->get(['id', 'name']);

        // Ambil opsi layout kolom dari helper function
        $columnLayouts = $this->getColumnLayoutOptions();
        $selectedComponents = $sectionData->components;

        // Buat JSON order awal (mirip ComponentController)
        $initialComponentOrderJson = $selectedComponents->map(function ($component) {
            // Gunakan pivot->order
            return ['id' => $component->id, 'order' => $component->pivot->order];
        })->values()->toJson(); // values() untuk re-index array setelah map

        // Data untuk form
        $formData = [
            'sectionData' => $sectionData, // Kirim data section yang akan diedit
            'availableComponents' => $availableComponents,
            'selectedComponents' => $selectedComponents, // Kirim collection komponen terpilih
            'initialComponentOrderJson' => $initialComponentOrderJson, // Kirim JSON order awal
        ];

        // Pastikan path view benar
        return view('template.default.backend.module.template.section.form',
            array_merge(
                $this->global_variable->PageType('edit'),
                $formData,
                ['columnLayouts' => $columnLayouts]
            )
        );
    }

    /**
     * Update the specified resource in storage.
     * Menggunakan method helper dari model Section.
     */
    public function update(SectionFormRequest $request, Section $section) // <-- PERBAIKAN: Gunakan SectionFormRequest & model binding
    {
        $validatedData = $request->validated();

        // Handle checkbox 'is_active' sudah dilakukan di SectionFormRequest->prepareForValidation()
        // Decode JSON 'components_order' sudah dilakukan di SectionFormRequest->prepareForValidation()

        // Logging validasi (opsional)
        if (isset($request->validator) && $request->validator->fails()) {
            // Log pada instance yang ada ($section dari model binding)
            activity()->causedBy(Auth::user())->performedOn($section)->log('Validation failed: '.$request->validator->messages()->toJson());
        }

        DB::beginTransaction();
        try {
            // Panggil method helper dari model Section
            // $validatedData sudah berisi 'is_active' (boolean) dan 'components_order' (array)
            $updatedSection = $this->section->updateSection($section->id, $validatedData);

            // Cek jika update berhasil (model helper mengembalikan instance atau null)
            if (!$updatedSection) {
                // Ini seharusnya tidak terjadi jika ID valid, tapi sebagai pengaman
                throw new \Exception($this->translation->section['messages']['update_failed_not_found'] ?? 'Section not found or failed to update.');
            }

            DB::commit();
            // Log pada instance yang diupdate ($section atau $updatedSection sama saja)
            activity()->causedBy(Auth::user())->performedOn($section)->log($this->translation->section['messages']['update_success'] ?? 'Section updated');

            return redirect()->route('section.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'] ?? 'Success',
                'content' => $this->translation->section['messages']['update_success'] ?? 'Section updated successfully.',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Section Update Error: '.$message.' Trace: '.$th->getTraceAsString());
            // Log pada instance yang ada ($section)
            activity()->causedBy(Auth::user())->performedOn($section)->log('Update failed: '.$message);

            return redirect()->back()->with([ // Gunakan redirect()->back()
                'error' => 'error',
                'title' => $this->translation->notification['error'] ?? 'Error',
                'content' => ($this->translation->section['messages']['update_failed'] ?? 'Failed to update section.').': '.$message,
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menggunakan method helper dari model Section.
     */
    public function destroy(Section $section) // Gunakan model binding
    {
        DB::beginTransaction();
        try {
            // Log sebelum delete
            activity()->causedBy(Auth::user())->performedOn($section)->log('Attempting to delete section');

            // Panggil method helper dari model Section
            $deleted = $this->section->deleteSection($section->id);

            if ($deleted) {
                DB::commit();
                // Log setelah berhasil delete (performedOn new instance karena $section sudah terhapus)
                activity()->causedBy(Auth::user())->performedOn(new Section())->log($this->translation->section['messages']['delete_success'] ?? 'Section deleted');

                // Return JSON response (konsisten dengan ComponentController)
                return response()->json([
                    'status' => 'success',
                    'message' => $this->translation->section['messages']['delete_success'] ?? 'Section deleted successfully.',
                ]);
            } else {
                // Jika model helper mengembalikan false (misal karena tidak ditemukan sebelum delete)
                DB::rollBack(); // Rollback jika delete di model gagal
                // Log kegagalan (performedOn new instance)
                activity()->causedBy(Auth::user())->performedOn(new Section())->log($this->translation->section['messages']['delete_failed_not_found'] ?? 'Failed to delete section (not found)');

                return response()->json([
                    'status' => 'error',
                    'message' => $this->translation->section['messages']['not_found'] ?? 'Section not found.', // Pesan lebih spesifik
                ], 404); // Not Found
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Section Delete Error: '.$message.' Trace: '.$th->getTraceAsString());
            // Log kegagalan (performedOn new instance)
            activity()->causedBy(Auth::user())->performedOn(new Section())->log('Delete failed: '.$message);

            return response()->json([
                'status' => 'error',
                'message' => ($this->translation->section['messages']['delete_failed'] ?? 'Failed to delete section.').': '.$message,
            ], 500); // Internal Server Error
        }
    }

    /**
     * Handle bulk deletion of sections.
     * Menggunakan SectionFormRequest untuk validasi.
     */
    public function bulkDestroy(SectionFormRequest $request) // <-- PERBAIKAN: Gunakan SectionFormRequest
    {
        // Validasi input 'ids' sekarang ditangani oleh SectionFormRequest
        $validated = $request->validated(); // Ambil data yang sudah divalidasi

        // Logging validasi (opsional, jika ingin log kegagalan bulk delete)
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Section())->log('Bulk delete validation failed: '.$request->validator->messages()->toJson());
            // Anda bisa langsung return error response di sini jika mau
            // return response()->json(['status' => 'error', 'message' => 'Validation failed.'], 422);
        }

        $ids = $validated['ids']; // Ambil ids dari data yang sudah divalidasi
        $deletedCount = 0;

        DB::beginTransaction();
        try {
            // --- Logika Bulk Delete Langsung di Controller (Konsisten) ---
            // Relasi pivot akan terhapus otomatis karena onDelete('cascade') di migrasi
            $deletedCount = Section::whereIn('id', $ids)->delete();
            // --- End Logika Bulk Delete ---

            if ($deletedCount > 0) {
                DB::commit();
                // Log setelah berhasil (performedOn new instance)
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn(new Section())
                    ->log(($this->translation->section['messages']['bulk_delete_success'] ?? 'Bulk delete success').' ('.$deletedCount.' items)');

                return response()->json([
                    'status' => 'success',
                    // Gunakan pesan dari translation
                    'message' => str_replace('{count}', $deletedCount, $this->translation->section['messages']['bulk_delete_success_count'] ?? '{count} items deleted successfully.'),
                ]);
            } else {
                DB::rollBack(); // Rollback jika tidak ada yang terhapus (misal ID tidak valid atau sudah terhapus)
                // Log jika tidak ada yang terhapus (performedOn new instance)
                activity()
                   ->causedBy(Auth::user())
                   ->performedOn(new Section())
                   ->log($this->translation->section['messages']['none_deleted'] ?? 'Bulk delete: No matching items found or deleted.');

                return response()->json([
                    'status' => 'error',
                    'message' => $this->translation->section['messages']['none_deleted'] ?? 'No matching items found or deleted.',
                ], 404); // Not Found
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($th);
            Log::error('Bulk Section Delete Error: '.$message.' Trace: '.$th->getTraceAsString());
            // Log kegagalan (performedOn new instance)
            activity()
                ->causedBy(Auth::user())
                ->performedOn(new Section())
                ->log('Bulk delete failed: '.$message);

            return response()->json([
                'status' => 'error',
                'message' => ($this->translation->section['messages']['bulk_delete_failed'] ?? 'Failed to delete items.').': '.$message,
            ], 500); // Internal Server Error
        }
    }

    // Helper private tidak diperlukan lagi karena logikanya ada di model
}
