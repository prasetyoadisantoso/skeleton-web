<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\UploadedFile;

class FileManagement
{
    /**
     *  Save all report into Json.
     */
    public function Logging($data = null)
    {
        return Storage::append('log/report.json', $data);
    }

    /**
     *  Upload profile image for testing purpose.
     */
    public function GetPathProfileImage()
    {
        $image = public_path('Test/Images/profile.png');
        $file = new UploadedFile($image, 'profile.png', 'image/png', null, true);

        return $file;
    }
}
