<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralFormRequest;
use App\Models\General;
use App\Services\FileManagement;
use App\Services\ResponseFormatter;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    protected $responseFormatter, $fileManagement, $general;

    public function __construct(
        ResponseFormatter $responseFormatter,
        FileManagement $fileManagement,
        General $general,
    )
    {
        $this->responseFormatter = $responseFormatter;
        $this->fileManagement = $fileManagement;
        $this->general = $general;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->general->query()->first();
        return $this->fileManagement->Logging($this->responseFormatter->successResponse($data));
    }

    /**
     * Update site description.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_site_description(GeneralFormRequest $request)
    {
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
            //  Return response
            $this->fileManagement->Logging($this->responseFormatter->successResponse($status));
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($message));
        }
    }

    /**
     * Update site logo.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_site_logo_favicon(GeneralFormRequest $request)
    {
        $request->validated();
        $validated_data = $request->only([
            'id', 'site_logo', 'site_favicon'
        ]);

        DB::beginTransaction();
        try {
            $general = $this->general->UpdateSiteLogoFavicon($validated_data);
            // check data updated or no
            if ($general == true) {
                $status = 'success';
            } else {
                $status = 'error';
            }
            DB::commit();
            //  Return response
            $this->fileManagement->Logging($this->responseFormatter->successResponse($status));
        } catch (\Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            if (str_contains($th->getMessage(), 'Duplicate entry')) {
                $message = 'Duplicate entry';
            }
            $this->fileManagement->Logging($this->responseFormatter->errorResponse($message));
        }
    }

}
