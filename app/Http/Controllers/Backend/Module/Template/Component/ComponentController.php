<?php

// Pastikan namespace benar sesuai lokasi file Anda
// namespace App\Http\Controllers\Backend\Module\Component;

namespace App\Http\Controllers\Backend\Module\Template\Component; // Sesuaikan dengan path Anda

use App\Http\Controllers\Controller;
use App\Http\Requests\ComponentFormRequest;
use App\Models\Component;
use App\Models\ContentImage; // <-- Hapus/Komentari
use App\Models\ContentText;  // <-- Hapus/Komentari
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables; // <-- Tambahkan jika belum ada

class ComponentController extends Controller
{
    protected $component;
    protected $contentImage; // <-- Hapus/Komentari
    protected $contentText;  // <-- Hapus/Komentari
    protected $global_variable;
    protected $global_view;
    protected $dataTables;
    protected $translation;

    public function __construct(
        Component $component,
        ContentImage $contentImage, // <-- Hapus/Komentari
        ContentText $contentText,   // <-- Hapus/Komentari
        GlobalVariable $global_variable,
        GlobalView $global_view,
        DataTables $dataTables,
        BackendTranslations $translation,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->only(['store', 'update']);
        $this->middleware(['permission:template-sidebar']);
        $this->middleware(['permission:component-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:component-create'])->only('create');
        $this->middleware(['permission:component-edit'])->only('edit');
        $this->middleware(['permission:component-store'])->only('store');
        $this->middleware(['permission:component-update'])->only('update');
        $this->middleware(['permission:component-destroy'])->only(['destroy', 'bulkDestroy']);

        $this->component = $component;
        $this->contentImage = $contentImage; // <-- Hapus/Komentari
        $this->contentText = $contentText;   // <-- Hapus/Komentari
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->dataTables = $dataTables;
        $this->translation = $translation;
    }

    protected function boot()
    {
        // Share global variables and translations to the view
        return $this->global_view->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->component['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations (Pastikan $this->translation->component ada dari BackendTranslations service)
            $this->translation->component,
            ['contentimage_trans' => $this->translation->contentimage],
            ['contenttext_trans' => $this->translation->contenttext],

            // Module
            $this->global_variable->ModuleType([
                'component-home',
                'component-form',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'component-home-js',
                'component-form-js',
                'sortable-js',
            ]),

            // Route Type
            $this->global_variable->RouteType('component.index'),
        ]);
    }

    public function index()
    {
        $this->boot();

        // Pastikan path view benar
        return view('template.default.backend.module.template.component.home',
            array_merge($this->global_variable->PageType('index'))
        );
    }

    public function index_dt()
    {
        $query = $this->component->getComponentsQuery()->orderBy('created_at', 'DESC');

        return $this->dataTables->of($query)
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->editColumn('description', function ($data) {
                return Str::limit(strip_tags($data->description), 50);
            })
            ->editColumn('is_active', function ($data) {
                // Tentukan data yang akan dikirim ke view
                $isActive = (bool) $data->is_active; // Pastikan boolean
                $badgeClass = $isActive ? 'bg-success' : 'bg-danger';
                $statusText = $isActive
                    ? ($this->translation->component['datatable']['status_active'] ?? 'Active')
                    : ($this->translation->component['datatable']['status_inactive'] ?? 'Inactive');

                // Kembalikan array berisi data, bukan HTML
                return [
                    'text' => $statusText,
                    'class' => $badgeClass,
                    'active' => $isActive // Opsional: kirim status boolean jika diperlukan di JS
                ];
            })
            ->addColumn('action', function ($data) {
                return $data->id;
            })
            ->rawColumns(['is_active', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $this->boot();

        // Ambil semua ContentImage yang tersedia untuk dipilih
        $availableImages = $this->contentImage->getContentImagesQuery()
                                ->orderBy('name', 'asc')
                                ->get(['id', 'name']); // Ambil ID dan Nama saja

        // Ambil ContentText jika masih dipakai
        $availableTexts = $this->contentText->getContentTextsQuery()
                               ->orderBy('created_at', 'asc')
                               ->get(['id', 'type', 'content']); // Ambil field yang relevan

        // Pastikan path view benar
        return view('template.default.backend.module.template.component.form',
            array_merge(
                $this->global_variable->PageType('create'),
                [
                    'availableImages' => $availableImages,
                    'availableTexts' => $availableTexts, // Jika masih dipakai
                    'selectedImages' => collect(), // Kirim collection kosong untuk create
                    'selectedTexts' => collect(),
                    'initialImageOrderJson' => '[]', // JSON kosong
                    'initialTextOrderJson' => '[]', // <-- JSON kosong
                ]
            )
        );
    }

    public function store(ComponentFormRequest $request)
    {
        $validatedData = $request->validated(); // Hanya berisi field dasar

        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new Component())->log($request->validator->messages()->toJson());
        }

        DB::beginTransaction();
        try {
            // Method storeComponent sudah disederhanakan
            $this->component->storeComponent($validatedData);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new Component())->log($this->translation->component['messages']['store_success']);

            return redirect()->route('component.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->component['messages']['store_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            Log::error('Component Store Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn(new Component())->log($message);

            return redirect()->route('component.create')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => ($this->translation->component['messages']['store_failed'] ?? 'Store failed').': '.$message,
            ])->withInput();
        }
    }

    public function show(Component $component)
    {
        abort(404);
    }

    public function edit(Component $component) // Model binding
    {
        $this->boot();

        // Eager load relasi
        $component->load(['contentImages', 'contentTexts']);

        $availableImages = $this->contentImage->getContentImagesQuery()
                                ->orderBy('name', 'asc')
                                ->get(['id', 'name']);

        $availableTexts = $this->contentText->getContentTextsQuery()
                               ->orderBy('type', 'asc') // Urutkan berdasarkan tipe atau field lain
                               ->get(['id', 'type', 'content']);

        // Data untuk Gambar
        $selectedImages = $component->contentImages;
        $initialImageOrderJson = $selectedImages->map(function ($img) {
            return ['id' => $img->id, 'order' => $img->pivot->order];
        })->values()->toJson();

        // Data untuk Text
        $selectedTexts = $component->contentTexts; // Ambil collection text terpilih
        $initialTextOrderJson = $selectedTexts->map(function ($txt) { // Buat JSON order text
            return ['id' => $txt->id, 'order' => $txt->pivot->order];
        })->values()->toJson();


        // Kirim data ke view
        return view('template.default.backend.module.template.component.form',
            array_merge(
                $this->global_variable->PageType('edit'),
                [
                    'componentData' => $component,
                    'availableImages' => $availableImages,
                    'availableTexts' => $availableTexts,
                    'selectedImages' => $selectedImages, // Untuk render list gambar awal
                    'initialImageOrderJson' => $initialImageOrderJson, // Untuk value awal input hidden gambar
                    'selectedTexts' => $selectedTexts, // Untuk render list text awal
                    'initialTextOrderJson' => $initialTextOrderJson, // Untuk value awal input hidden text
                    // 'selectedTextIds' => $selectedTextIds, // Hapus baris ini
                ]
            )
        );
    }


    public function update(ComponentFormRequest $request, Component $component)
    {
        $validatedData = $request->validated(); // Hanya berisi field dasar

        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn($component)->log($request->validator->messages()->toJson());
        }

        DB::beginTransaction();
        try {
            // Method updateComponent sudah disederhanakan
            $this->component->updateComponent($component->id, $validatedData);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn($component)->log($this->translation->component['messages']['update_success']);

            return redirect()->route('component.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->component['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            Log::error('Component Update Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn($component)->log($message);

            return redirect()->route('component.edit', $component->id)->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => ($this->translation->component['messages']['update_failed'] ?? 'Update failed').': '.$message,
            ])->withInput();
        }
    }

    public function destroy(Component $component)
    {
        DB::beginTransaction();
        try {
            $deleted = $this->component->deleteComponent($component->id);

            DB::commit();

            if ($deleted) {
                activity()->causedBy(Auth::user())->performedOn(new Component())->log($this->translation->component['messages']['delete_success']);

                return response()->json(['status' => 'success']);
            } else {
                activity()->causedBy(Auth::user())->performedOn(new Component())->log($this->translation->component['messages']['delete_failed']);

                return response()->json(['status' => 'error', 'message' => $this->translation->component['messages']['delete_failed']], 500);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            Log::error('Component Delete Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn(new Component())->log($message);

            return response()->json(['status' => 'error', 'message' => $message], 500);
        }
    }

    public function bulkDestroy(ComponentFormRequest $request)
    {
        $validatedData = $request->validated();
        $ids = $validatedData['ids'];
        $deletedCount = 0;

        DB::beginTransaction();
        try {
            $deletedCount = Component::whereIn('id', $ids)->delete();

            if ($deletedCount > 0) {
                DB::commit();
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn(new Component())
                    ->log(($this->translation->component['messages']['bulk_delete_success'] ?? 'Bulk delete success').' ('.$deletedCount.' items)');

                return response()->json([
                    'status' => 'success',
                    'message' => ($this->translation->component['messages']['bulk_delete_success'] ?? '{count} items deleted successfully.').' ('.$deletedCount.' items)',
                ]);
            } else {
                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'message' => $this->translation->component['messages']['none_deleted'] ?? 'No matching items found or deleted.',
                ], 404);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Bulk Component Delete Error: '.$th->getMessage().' Trace: '.$th->getTraceAsString());
            activity()
                ->causedBy(Auth::user())
                ->performedOn(new Component())
                ->log('Bulk delete failed: '.$th->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => ($this->translation->component['messages']['bulk_delete_failed'] ?? 'Failed to delete items.').': '.$th->getMessage(),
            ], 500);
        }
    }
}
