<?php

namespace App\Http\Controllers\Backend\Module\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralFormRequest;
use App\Models\General;
use App\Models\MediaLibrary;
use App\Services\BackendTranslations;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    protected $global_view;
    protected $global_variable;
    protected $translation;
    protected $responseFormatter;
    protected $fileManagement;
    protected $general;
    protected $upload;

    public function __construct(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        BackendTranslations $translation,
        General $general,
        Upload $upload,
    ) {
        $this->middleware(['auth', 'verified', 'xss']);
        $this->middleware(['permission:setting-sidebar']);
        $this->middleware(['permission:general-index'])->only(['index']);
        $this->middleware(['permission:general-update'])->only(['update_site_description', 'update_site_logo_favicon']);

        $this->responseFormatter = $responseFormatter;
        $this->global_variable = $global_variable;
        $this->global_view = $global_view;
        $this->translation = $translation;
        $this->fileManagement = $fileManagement;
        $this->general = $general;
        $this->upload = $upload;
    }

    /**
     * Boot Service.
     */
    protected function boot()
    {
        // Render to View
        $this->global_view->RenderView([
            // Global Variable
            $this->global_variable->TitlePage($this->translation->general['title']),
            $this->global_variable->SystemLanguage(),
            $this->global_variable->AuthUserName(),
            $this->global_variable->SystemName(),
            $this->global_variable->SiteLogo(),
            $this->global_variable->MessageNotification(),

            // Translations
            $this->translation->header,
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->notification,
            $this->translation->general,

            // Module
            $this->global_variable->ModuleType([
                'general-home',
            ]),

            // Script
            $this->global_variable->ScriptType([
                'general-js',
            ]),
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
        $data = $this->general->query()->first();

        return view('template.default.backend.module.settings.general.home', array_merge(
            ['data' => $data]
        ));
        // return $this->fileManagement->Logging($this->responseFormatter->successResponse($data));
    }

    /**
     * Update site description.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_site_description(GeneralFormRequest $request)
    {
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new General())->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only([
            'id', 'site_title', 'site_tagline', 'site_email', 'url_address', 'google_tag', 'copyright', 'cookies_concern',
        ]);

        DB::beginTransaction();
        try {
            $general = $this->general->UpdateSiteDescription($validated_data);
            // check data updated or no
            if ($general == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new General())->log($this->translation->general['messages']['update_success']);

            return redirect()->route('general.index')->with([
                'success' => $status,
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->general['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new General())->log($message);

            return redirect()->route('general.index')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }

    /**
     * Update site logo.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_site_logo_favicon(GeneralFormRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new General())->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only(['id', 'site_logo', 'site_favicon']);
        $general = $this->general->query()->find($validated_data['id']);

        DB::beginTransaction();
        try {
            // Handle Logo Upload
            if ($request->hasFile('site_logo')) {
                $logoFile = $request->file('site_logo');
                $logoData = $this->upload->UploadImageLogoToMediaLibrary($logoFile);

                // Delete old logo if exists
                if ($general->site_logo_id) {
                    $oldLogo = MediaLibrary::find($general->site_logo_id);
                    if ($oldLogo) {
                        Storage::delete('public/'.$oldLogo->media_files);
                        $oldLogo->delete();
                    }
                }

                // Create new MediaLibrary entry for logo
                $logoMedia = MediaLibrary::create([
                    'title' => pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME), // Gunakan nama file asli
                    'media_files' => $logoData['media_path'], // Simpan path yang dikembalikan UploadImageLogoToStorage
                    'type' => 'logo',
                    'information' => '',
                    'description' => '',
                ]);

                $general->site_logo_id = $logoMedia->id;
            }

            // Handle Favicon Upload
            if ($request->hasFile('site_favicon')) {
                $faviconFile = $request->file('site_favicon');
                $faviconData = $this->upload->UploadImageFaviconToMediaLibrary($faviconFile);

                // Delete old favicon if exists
                if ($general->site_favicon_id) {
                    $oldFavicon = MediaLibrary::find($general->site_favicon_id);
                    if ($oldFavicon) {
                        Storage::delete('public/'.$oldFavicon->media_files);
                        $oldFavicon->delete();
                    }
                }

                // Create new MediaLibrary entry for favicon
                $faviconMedia = MediaLibrary::create([
                    'title' => pathinfo($faviconFile->getClientOriginalName(), PATHINFO_FILENAME), // Gunakan nama file asli
                    'media_files' => $faviconData['media_path'], // Simpan path yang dikembalikan UploadImageFaviconToStorage
                    'type' => 'favicon',
                    'information' => '',
                    'description' => '',
                ]);

                $general->site_favicon_id = $faviconMedia->id;
            }

            $general->save();

            $status = 'success';

            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new General())->log($this->translation->general['messages']['update_success']);

            return redirect()->route('general.index')->with([
                'success' => $status,
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->general['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            report($message);
            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new General())->log($message);

            return redirect()->route('general.index')->with([
                'error' => 'error',
                'title' => $this->translation->notification['error'],
                'content' => $message,
            ]);
        }
    }
}
