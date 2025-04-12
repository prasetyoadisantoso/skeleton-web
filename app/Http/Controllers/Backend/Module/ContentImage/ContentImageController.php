<?php

namespace App\Http\Controllers\Backend\Module\ContentImage;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentImageFormRequest; // Akan dibuat nanti
use App\Models\ContentImage;
use App\Models\MediaLibrary;
use App\Services\BackendTranslations;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ContentImageController extends Controller
{
    protected $upload;
    protected $contentImage;
    protected $mediaLibrary;
    protected $global_variable;
    protected $global_view;
    protected $dataTables;
    protected $translation;

    public function __construct(
        Upload $upload,
        ContentImage $contentImage,
        MediaLibrary $mediaLibrary,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        DataTables $dataTables,
        BackendTranslations $translation,
    ) {
        $this->middleware(['auth', 'verified']);
        $this->middleware(['xss'])->only(['store', 'update']);
        // $this->middleware(['xss-sanitize'])->only(['store', 'update']); // Hati-hati jika caption butuh HTML
        // Definisikan permission baru
        $this->middleware(['permission:content-sidebar']);
        $this->middleware(['permission:contentimage-index'])->only(['index', 'index_dt']);
        $this->middleware(['permission:contentimage-create'])->only('create');
        $this->middleware(['permission:contentimage-edit'])->only('edit');
        $this->middleware(['permission:contentimage-store'])->only('store');
        $this->middleware(['permission:contentimage-update'])->only('update');
        $this->middleware(['permission:contentimage-destroy'])->only('destroy');

        $this->upload = $upload;
        $this->contentImage = $contentImage;
        $this->mediaLibrary = $mediaLibrary;
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->dataTables = $dataTables;
        $this->translation = $translation;

        // Load translation untuk contentimage
        $this->translation = $translation;
    }

    protected function boot()
    {

        // Share global variables and translations to the view
        return $this->global_view->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->contentimage['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->contentimage,

            // Module
            $this->global_variable->ModuleType([
                'contentimage-home', // Ganti
                'contentimage-form',  // Ganti
            ]),

            // Script
            $this->global_variable->ScriptType([
                'contentimage-home-js', // Ganti
                'contentimage-form-js',  // Ganti
            ]),

            // Route Type
            $this->global_variable->RouteType('content-image.index'), // Ganti
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->boot();

        return view('template.default.backend.module.content.image.home', // Ganti path view
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
        // Ambil data dengan relasi mediaLibrary
        $query = $this->contentImage->getContentImagesQuery()->orderBy('created_at', 'DESC');

        return $this->dataTables->of($query)
            ->addColumn('image', function ($data) {
                if ($data->mediaLibrary) {
                    $url = Storage::url($data->mediaLibrary->media_files);

                    return '<img src="'.$url.'" alt="'.e($data->alt_text).'" style="max-width: 100px; max-height: 100px;">';
                }

                return 'No Image';
            })
            ->addColumn('alt_text', function ($data) {
                return $data->alt_text;
            })
            ->addColumn('caption', function ($data) {
                // Batasi panjang caption jika perlu
                return \Illuminate\Support\Str::limit($data->caption, 50);
            })
            ->addColumn('action', function ($data) {
                // Return ID untuk tombol action di JS
                return $data->id;
            })
            ->rawColumns(['image', 'action']) // Render HTML untuk kolom image dan action
            ->removeColumn('media_library_id') // Hapus kolom ID relasi
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->boot();

        return view('template.default.backend.module.content.image.form', // Ganti path view
            array_merge($this->global_variable->PageType('create'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentImageFormRequest $request) // Gunakan Form Request
    {
        $request->validated();
        $data = $request->only(['name', 'alt_text', 'caption']);
        $mediaFile = $request->file('media_file'); // Nama input file

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($request->validator->messages());
        }

        DB::beginTransaction();
        try {
            if (!$mediaFile) {
                throw new \Exception($this->translation->contentimage['validation']['media_file_required']);
            }

            // 1. Upload file dan buat record MediaLibrary
            // Gunakan method upload yang sesuai, misal untuk image saja
            $uploadedMedia = $this->upload->UploadFileMediaLibrary($mediaFile); // Atau method lain yang sesuai

            $mediaLibraryData = [
                'title' => $uploadedMedia['media_name'], // Judul default dari nama file
                'information' => $data['caption'] ?? '', // Opsional: gunakan caption
                'description' => '', // Opsional
                'media-files' => $uploadedMedia['media_path'],
            ];

            $newMediaLibrary = $this->mediaLibrary->StoreMediaLibrary($mediaLibraryData);

            // 2. Buat record ContentImage
            $contentImageData = [
                'name' => $data['name'],
                'media_library_id' => $newMediaLibrary->id,
                'alt_text' => $data['alt_text'],
                'caption' => $data['caption'],
            ];
            $this->contentImage->storeContentImage($contentImageData);

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($this->translation->contentimage['messages']['store_success']);

            return redirect()->route('content-image.index')->with([ // Ganti route
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->contentimage['messages']['store_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            // Hapus file yang mungkin sudah terupload jika terjadi error setelah upload
            if (isset($uploadedMedia['media_path'])) {
                Storage::delete('public/'.$uploadedMedia['media_path']);
            }

            $message = $th->getMessage();
            report($message); // Log error
            Log::error('Content Image Store Error: '.$message.' Trace: '.$th->getTraceAsString()); // Log lebih detail
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($message);

            return redirect()->route('content-image.create')->with([ // Ganti route
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                // Tampilkan pesan error yang lebih user-friendly jika perlu
                'content' => $this->translation->contentimage['messages']['store_failed'].': '.$message,
            ])->withInput(); // Kembalikan input sebelumnya
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Biasanya tidak digunakan di backend index/list
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->boot();
        $contentImageData = $this->contentImage->getContentImageById($id);

        if (!$contentImageData) {
            abort(404);
        }

        return view('template.default.backend.module.content.image.form', // Ganti path view
            array_merge(
                $this->global_variable->PageType('edit'),
                ['contentImageData' => $contentImageData]
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentImageFormRequest $request, string $id) // Gunakan Form Request
    {
        $request->validated();
        $data = $request->only(['name', 'alt_text', 'caption']);
        $mediaFile = $request->file('media_file'); // Nama input file

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($request->validator->messages());
        }

        DB::beginTransaction();
        try {
            $currentContentImage = $this->contentImage->find($id);
            if (!$currentContentImage) {
                throw new \Exception($this->translation->contentimage['messages']['not_found']); // Tambahkan pesan not found
            }

            $oldMediaLibraryId = $currentContentImage->media_library_id;
            $newMediaLibraryId = $oldMediaLibraryId; // Defaultnya tetap ID lama

            // Jika ada file baru diupload
            if ($mediaFile) {
                // 1. Upload file baru dan buat record MediaLibrary baru
                $uploadedMedia = $this->upload->UploadFileMediaLibrary($mediaFile); // Atau method lain yang sesuai
                $mediaLibraryData = [
                    'title' => $uploadedMedia['media_name'],
                    'information' => $data['caption'] ?? '',
                    'description' => '',
                    'media-files' => $uploadedMedia['media_path'],
                ];
                $newMediaLibrary = $this->mediaLibrary->StoreMediaLibrary($mediaLibraryData);
                $newMediaLibraryId = $newMediaLibrary->id;
            }

            // 2. Update record ContentImage
            $updateData = [
                'name' => $data['name'],
                'media_library_id' => $newMediaLibraryId, // Gunakan ID baru jika ada, jika tidak tetap ID lama
                'alt_text' => $data['alt_text'],
                'caption' => $data['caption'],
            ];
            $this->contentImage->updateContentImage($id, $updateData);

            // 3. Jika ada file baru, hapus MediaLibrary lama (dan file-nya via cascade/event)
            if ($mediaFile && $oldMediaLibraryId) {
                // Panggil method delete MediaLibrary (yang juga menghapus file fisiknya)
                $this->mediaLibrary->DeleteMediaLibrary($oldMediaLibraryId);
            }

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($this->translation->contentimage['messages']['update_success']);

            return redirect()->route('content-image.index')->with([ // Ganti route
                'success' => 'success',
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->contentimage['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message); // Log error
            Log::error('Content Image Update Error: '.$message.' Trace: '.$th->getTraceAsString()); // Log lebih detail
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($message);

            return redirect()->route('content-image.edit', $id)->with([ // Ganti route
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $this->translation->contentimage['messages']['update_failed'].': '.$message,
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
            $contentImage = $this->contentImage->find($id);
            if (!$contentImage) {
                return response()->json(['status' => 'error', 'message' => $this->translation->contentimage['messages']['not_found'] ?? 'Data not found'], 404);
            }

            $mediaLibraryId = $contentImage->media_library_id;

            // Hapus ContentImage (cascade akan menghapus MediaLibrary jika di-setting di migration)
            $deleted = $this->contentImage->deleteContentImage($id);

            // Jika tidak menggunakan cascade, hapus MediaLibrary secara manual
            // if ($deleted && $mediaLibraryId) {
            //     $this->mediaLibrary->DeleteMediaLibrary($mediaLibraryId); // Pastikan ini menghapus file juga
            // }

            DB::commit();

            if ($deleted) {
                activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($this->translation->contentimage['messages']['delete_success']);

                return response()->json(['status' => 'success']);
            } else {
                activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($this->translation->contentimage['messages']['delete_failed']);

                return response()->json(['status' => 'error', 'message' => $this->translation->contentimage['messages']['delete_failed']], 500);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            Log::error('Content Image Delete Error: '.$message.' Trace: '.$th->getTraceAsString());
            activity()->causedBy(Auth::user())->performedOn(new ContentImage())->log($message);

            // Return response error json untuk datatable
            return response()->json(['status' => 'error', 'message' => $message], 500);
        }
    }

    /**
     * Remove multiple specified resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(ContentImageFormRequest $request) // <-- Ganti type hint
    {
        // 1. Validasi input (Sekarang ditangani oleh ContentImageFormRequest)
        // $request->validate([ ... ]); // <-- HAPUS ATAU KOMENTARI INI

        // Ambil data yang sudah divalidasi (jika perlu, tapi di sini hanya perlu 'ids')
        $validatedData = $request->validated();
        $ids = $validatedData['ids']; // Ambil 'ids' dari data yang sudah divalidasi

        $deletedCount = 0;
        // $failedCount = 0; // Tidak digunakan saat ini

        DB::beginTransaction();
        try {
            // Lakukan penghapusan (mengandalkan cascade delete di DB untuk MediaLibrary)
            $deletedCount = ContentImage::whereIn('id', $ids)->delete();

            if ($deletedCount > 0) {
                DB::commit();
                // Log aktivitas (contoh sederhana)
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn(new ContentImage()) // Target umum
                    ->log(($this->translation->contentimage['messages']['bulk_delete_success'] ?? 'Bulk delete success') . ' (' . $deletedCount . ' items)'); // Gunakan fallback jika translation tidak ada

                return response()->json([
                    'status' => 'success',
                    'message' => ($this->translation->contentimage['messages']['bulk_delete_success'] ?? '{count} items deleted successfully.') . ' (' . $deletedCount . ' items)' // Gunakan fallback
                ]);
            } else {
                // Jika tidak ada yang terhapus (mungkin ID tidak valid setelah validasi UUID)
                DB::rollBack(); // Rollback jika tidak ada yang terhapus
                return response()->json([
                    'status' => 'error',
                    'message' => $this->translation->contentimage['messages']['none_deleted'] ?? 'No matching items found or deleted.' // Gunakan fallback
                ], 404); // Not Found atau Bad Request
            }

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Bulk Content Image Delete Error: ' . $th->getMessage() . ' Trace: ' . $th->getTraceAsString());
            activity()
                ->causedBy(Auth::user())
                ->performedOn(new ContentImage())
                ->log('Bulk delete failed: ' . $th->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => ($this->translation->contentimage['messages']['bulk_delete_failed'] ?? 'Failed to delete items.') . ': ' . $th->getMessage() // Gunakan fallback
            ], 500); // Internal Server Error
        }
    }
}
