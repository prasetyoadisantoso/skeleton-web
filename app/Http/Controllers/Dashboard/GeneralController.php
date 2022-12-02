<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralFormRequest;
use App\Models\General;
use App\Services\FileManagement;
use App\Services\GlobalVariable;
use App\Services\GlobalView;
use App\Services\ResponseFormatter;
use App\Services\Translations;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    protected $global_view, $global_variable, $translation, $responseFormatter, $fileManagement, $general, $upload;

    public function __construct(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        GlobalVariable $global_variable,
        GlobalView $global_view,
        Translations $translation,
        General $general,
        Upload $upload,
    )
    {
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
     * Boot Service
     *
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

            // Translations
            $this->translation->sidebar,
            $this->translation->button,
            $this->translation->notification,
            $this->translation->general,

            // Module
            $this->global_variable->ModuleType([
                'general-home'
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
        return view('template.default.dashboard.settings.general.home', array_merge(
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
            activity()->causedBy(Auth::user())->performedOn(new General)->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only([
            'id', 'site_title', 'site_tagline', 'url_address', 'copyright', 'cookies_concern'
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
            activity()->causedBy(Auth::user())->performedOn(new General)->log($this->translation->general['messages']['update_success']);
            return redirect()->route('general.index')->with([
                'success' => $status,
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->general['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new General)->log($message);
            return redirect()->route('general.create')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
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
        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new General)->log($request->validator->messages());
        }

        $request->validated();
        $validated_data = $request->only([
            'id', 'site_logo', 'site_favicon'
        ]);

        DB::beginTransaction();
        try {

            if ($request->file('site_logo')) {
                $image = $this->upload->UploadImageLogoToStorage($validated_data['site_logo']);
                $validated_data['site_logo'] = $image;
            }

            if ($request->file('site_favicon')) {
                $image = $this->upload->UploadImageFaviconToStorage($validated_data['site_favicon']);
                $validated_data['site_favicon'] = $image;
            }

            $general = $this->general->UpdateSiteLogoFavicon($validated_data);
            // check data updated or no
            if ($general == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }
            DB::commit();
            activity()->causedBy(Auth::user())->performedOn(new General)->log($this->translation->general['messages']['update_success']);
            return redirect()->route('general.index')->with([
                'success' => $status,
                'title' => $this->translation->notification['success'],
                'content' => $this->translation->general['messages']['update_success'],
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            activity()->causedBy(Auth::user())->performedOn(new General)->log($message);
            return redirect()->route('general.index')->with([
                'error' => 'error',
                "title" => $this->translation->notification['error'],
                "content" => $message,
            ]);
        }
    }

}
