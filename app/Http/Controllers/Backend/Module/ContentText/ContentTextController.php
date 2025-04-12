<?php

namespace App\Http\Controllers\Backend\Module\ContentText;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentTextFormRequest; // Akan dibuat nanti
use App\Models\ContentText; // Ganti model
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use Illuminate\Http\Request; // Tambahkan use Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ContentTextController extends Controller
{
    protected $contentText; // Ganti nama properti
    protected $global_variable;
    protected $global_view;
    protected $dataTables;
    protected $translation;

    public function __construct(
        ContentText $contentText, // Ganti model
        GlobalVariable $global_variable,
        GlobalView $global_view,
        DataTables $dataTables,
        BackendTranslations $translation,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->only(['store', 'update']);
        // Definisikan permission baru
        $this->middleware(['permission:content-sidebar']); // Ganti permission
        $this->middleware(['permission:contenttext-index'])->only(['index', 'index_dt']); // Ganti permission
        $this->middleware(['permission:contenttext-create'])->only('create'); // Ganti permission
        $this->middleware(['permission:contenttext-edit'])->only('edit'); // Ganti permission
        $this->middleware(['permission:contenttext-store'])->only('store'); // Ganti permission
        $this->middleware(['permission:contenttext-update'])->only('update'); // Ganti permission
        $this->middleware(['permission:contenttext-destroy'])->only(['destroy', 'bulkDestroy']); // Ganti permission

        $this->contentText = $contentText; // Ganti model
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
            $this->global_variable->TitlePage($this->translation->contenttext['title']), // Ganti var
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->contenttext,

            // Module
            $this->global_variable->ModuleType([
                'contenttext-home', // Ganti
                'contenttext-form',  // Ganti
            ]),

            // Script
            $this->global_variable->ScriptType([
                'contenttext-home-js', // Ganti
                'contenttext-form-js',  // Ganti
            ]),

            // Route Type
            $this->global_variable->RouteType('content-text.index'), // Ganti
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->boot();
        // Ganti path view
        return view('template.default.backend.module.content.text.home',
            array_merge($this->global_variable->PageType('index'))
        );
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index_dt()
    {
        // Ambil data
        $query = $this->contentText->getContentTextsQuery()->orderBy('created_at', 'DESC'); // Ganti model

        return $this->dataTables->of($query)
            ->addColumn('type', function ($data) {
                // Tampilkan tipe dengan format yang lebih baik
                return match ($data->type) {
                    'h1' => 'Heading 1',
                    'h2' => 'Heading 2',
                    'h3' => 'Heading 3',
                    'h4' => 'Heading 4',
                    'h5' => 'Heading 5',
                    'h6' => 'Heading 6',
                    'paragraph' => 'Paragraph',
                    default => ucfirst($data->type),
                };
            })
            ->addColumn('content', function ($data) {
                // Batasi panjang konten di tabel
                return \Illuminate\Support\Str::limit(strip_tags($data->content), 100); // Hapus tag HTML & batasi
            })
            ->addColumn('action', function ($data) {
                // Return ID untuk tombol action di JS
                return $data->id;
            })
            // ->rawColumns(['action']) // Tidak perlu raw jika action hanya ID
            ->addIndexColumn()
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->boot();
        // Ganti path view
        return view('template.default.backend.module.content.text.form',
            array_merge($this->global_variable->PageType('create'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentTextFormRequest $request) // Gunakan Form Request
    {
        // Validasi sudah ditangani oleh Form Request
        $validatedData = $request->validated();

        // Error Validation Message to Activity Log (jika perlu, tapi biasanya tidak sampai sini jika validasi gagal)
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($request->validator->messages());
        }

        DB::beginTransaction();
        try {
            // Simpan data menggunakan method model
            $this->contentText->storeContentText($validatedData); // Ganti model

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($this->translation->contenttext['messages']['store_success']); // Ganti var

            // Ganti route
            return redirect()->route('content-text.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->contenttext['messages']['store_success'], // Ganti var
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message); // Log error
            Log::error('Content Text Store Error: '.$message.' Trace: '.$th->getTraceAsString()); // Ganti log context
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($message); // Ganti model

            // Ganti route
            return redirect()->route('content-text.create')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $this->translation->contenttext['messages']['store_failed'] . ': ' . $message, // Ganti var
            ])->withInput(); // Kembalikan input sebelumnya
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->boot();
        $contentTextData = $this->contentText->getContentTextById($id); // Ganti model

        if (!$contentTextData) {
            abort(404);
        }

        // Ganti path view
        return view('template.default.backend.module.content.text.form',
            array_merge(
                $this->global_variable->PageType('edit'),
                ['contentTextData' => $contentTextData] // Ganti nama variabel data
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentTextFormRequest $request, string $id) // Gunakan Form Request
    {
        // Validasi sudah ditangani oleh Form Request
        $validatedData = $request->validated();

        // Error Validation Message to Activity Log (jika perlu)
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($request->validator->messages());
        }

        DB::beginTransaction();
        try {
            // Update data menggunakan method model
            $updated = $this->contentText->updateContentText($id, $validatedData); // Ganti model

            if (!$updated) {
                 throw new \Exception($this->translation->contenttext['messages']['not_found']); // Ganti var
            }

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($this->translation->contenttext['messages']['update_success']); // Ganti var

            // Ganti route
            return redirect()->route('content-text.index')->with([
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->contenttext['messages']['update_success'], // Ganti var
            ]);

        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message); // Log error
            Log::error('Content Text Update Error: '.$message.' Trace: '.$th->getTraceAsString()); // Ganti log context
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($message); // Ganti model

            // Ganti route
            return redirect()->route('content-text.edit', $id)->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $this->translation->contenttext['messages']['update_failed'] . ': ' . $message, // Ganti var
            ])->withInput(); // Kembalikan input sebelumnya
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            // Hapus data menggunakan method model
            $deleted = $this->contentText->deleteContentText($id); // Ganti model

            if (!$deleted) {
                 // Mungkin sudah dihapus atau ID tidak valid
                 DB::rollBack(); // Rollback jika tidak ada yang dihapus
                 return response()->json(['status' => 'error', 'message' => $this->translation->contenttext['messages']['not_found'] ?? 'Data not found'], 404); // Ganti var
            }

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($this->translation->contenttext['messages']['delete_success']); // Ganti var
            return response()->json(['status' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            Log::error('Content Text Delete Error: '.$message.' Trace: '.$th->getTraceAsString()); // Ganti log context
            activity()->causedBy(Auth::user())->performedOn(new ContentText())->log($message); // Ganti model

            // Return response error json untuk datatable
             return response()->json(['status' => 'error', 'message' => $message], 500);
        }
    }

     /**
     * Remove multiple specified resources from storage.
     *
     * @param  \App\Http\Requests\ContentTextFormRequest  $request // Gunakan Form Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(ContentTextFormRequest $request) // Gunakan Form Request
    {
        // Validasi sudah ditangani oleh Form Request
        $validatedData = $request->validated();
        $ids = $validatedData['ids'];

        $deletedCount = 0;

        DB::beginTransaction();
        try {
            // Lakukan penghapusan
            $deletedCount = ContentText::whereIn('id', $ids)->delete(); // Ganti model

            if ($deletedCount > 0) {
                DB::commit();
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn(new ContentText())
                    ->log(($this->translation->contenttext['messages']['bulk_delete_success'] ?? 'Bulk delete success') . ' (' . $deletedCount . ' items)'); // Ganti var

                return response()->json([
                    'status' => 'success',
                    'message' => ($this->translation->contenttext['messages']['bulk_delete_success'] ?? '{count} items deleted successfully.') . ' (' . $deletedCount . ' items)' // Ganti var
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => $this->translation->contenttext['messages']['none_deleted'] ?? 'No matching items found or deleted.' // Ganti var
                ], 404);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Bulk Content Text Delete Error: ' . $th->getMessage() . ' Trace: ' . $th->getTraceAsString()); // Ganti log context
            activity()
                ->causedBy(Auth::user())
                ->performedOn(new ContentText())
                ->log('Bulk delete failed: ' . $th->getMessage()); // Ganti model

            return response()->json([
                'status' => 'error',
                'message' => ($this->translation->contenttext['messages']['bulk_delete_failed'] ?? 'Failed to delete items.') . ': ' . $th->getMessage() // Ganti var
            ], 500);
        }
    }
}
