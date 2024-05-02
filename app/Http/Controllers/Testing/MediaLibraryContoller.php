<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MediaLibraryFormRequest;
use App\Models\MediaLibrary;
use App\Services\Upload;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GlobalVariable;

class MediaLibraryContoller extends Controller
{
    protected $upload;

    protected $medialibrary, $global_variable;

    public function __construct(
        Upload $upload,
        MediaLibrary $medialibrary,
        GlobalVariable $global_variable,
    ) {
        $this->upload = $upload;
        $this->medialibrary = $medialibrary;
        $this->global_variable = $global_variable;
    }

    public function index()
    {
        $data = $this->medialibrary->get();
        return view('testing.test', array_merge($this->global_variable->PageType('index'), [
            'data' => $data
        ]));
    }

    public function create()
    {
        return view('testing.test', array_merge($this->global_variable->PageType('create')));
    }

    public function store(MediaLibraryFormRequest $request)
    {
        $request->validated();
        $data = $request->only(['title', 'information', 'description', 'media-files']);

        // Error Validation Message to Activity Log
        if (isset($request->validator) && $request->validator->fails()) {
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary())->log($request->validator->messages());
        }

        try {

            // Upload function
            if ($request->file('media-files') != null) {
                $media_file = $this->upload->UploadFileMediaLibrary($data['media-files']);
                $data['media-files'] = $media_file['media_path'];

                if (isset($data['title'])) {
                    $data['title'] = $data['title'];
                } else {
                    $data['title'] = $media_file['media_name'];
                }

            } else {
                $error = 'Media file not found';
            }

            if (isset($error)) {
                throw new Exception($error, 1);
            }

            // Store Data
            $this->medialibrary->StoreMediaLibrary($data);

            return redirect()->route('media-library.create');

        } catch (\Throwable $th) {
            $message = $th->getMessage();
            report($message);
            activity()->causedBy(Auth::user())->performedOn(new MediaLibrary)->log($message);
            return redirect()->route('media-library.create')->with(['errors' => $message]);
        }

    }

    public function show()
    {
    }

    public function edit($id)
    {
        $medialibrary = $this->medialibrary->GetMediaLibraryById($id);
        $pathInfo = pathinfo($medialibrary->media_files);
        return view('testing.test', array_merge($this->global_variable->PageType('edit'), [
            'medialibrary' => $medialibrary,
            'basename' => $pathInfo['basename'],
            'extensions' => $pathInfo['extension']
        ]));
    }

    public function update(MediaLibraryFormRequest $request, $id)
    {

        $request->validated();
        $data = $request->only(['title', 'information', 'description']);


        $medialibrarydata = $this->medialibrary->UpdateMediaLibrary($data, $id);

    }

    public function destroy($id)
    {
        $delete = $this->medialibrary->DeleteMediaLibrary($id);
        return redirect()->route('media-library.index');
    }
}
