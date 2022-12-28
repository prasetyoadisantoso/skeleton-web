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
     *  Upload profile image for development purpose.
     */
    public function GetPathProfileImage($role = null)
    {
        if($role == 'superadmin'){
            $image = public_path('Test/Images/superadmin.png');
        } else if ($role == 'admin'){
            $image = public_path('Test/Images/admin.png');
        } else if ($role == 'customer'){
            $image = public_path('Test/Images/customer.png');
        } else if ($role == 'editor'){
            $image = public_path('Test/Images/editor.png');
        } else if ($role == 'guest'){
            $image = public_path('Test/Images/guest.png');
        } else {
            $image = public_path('Test/Images/profile.png');
        }

        $file = new UploadedFile($image, 'profile.png', 'image/png', null, true);

        return $file;
    }

    /**
     *  Upload Logo for development purpose
     */
    public function GetPathLogoImage()
    {
        $image = public_path('Test/Images/logo.png');
        $file = new UploadedFile($image, 'profile.png', 'image/png', null, true);
        return $file;
    }

    /**
     *  Upload Favicon for development purpose
     */
    public function GetPathFaviconImage()
    {
        $image = public_path('Test/Images/favicon.png');
        $file = new UploadedFile($image, 'profile.png', 'image/png', null, true);
        return $file;
    }

    /**
     *  Upload Feature Image for development purpose
     */
    public function GetPathFeatureImage()
    {
        $image = public_path('Test/Images/feature-image.png');
        $file = new UploadedFile($image, 'profile.png', 'image/png', null, true);
        return $file;
    }
}
