<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        if ($role == 'superadmin') {
            $image = public_path('Test/Images/superadmin.png');
        } elseif ($role == 'administrator') {
            $image = public_path('Test/Images/admin.png');
        } elseif ($role == 'customer') {
            $image = public_path('Test/Images/customer.png');
        } elseif ($role == 'editor') {
            $image = public_path('Test/Images/editor.png');
        } elseif ($role == 'guest') {
            $image = public_path('Test/Images/guest.png');
        } else {
            $image = public_path('Test/Images/guest.png');
        }

        $file = new UploadedFile($image, 'profile.png', 'image/png', null, true);

        return $file;
    }

    /**
     *  Upload Logo for development purpose.
     */
    public function GetPathLogoImage()
    {
        $image = public_path('Test/Images/logo.png');
        $file = new UploadedFile($image, 'logo.png', 'image/png', null, true);

        return $file;
    }

    /**
     *  Upload Favicon for development purpose.
     */
    public function GetPathFaviconImage()
    {
        $image = public_path('Test/Images/favicon.png');
        $file = new UploadedFile($image, 'favicon.png', 'image/png', null, true);

        return $file;
    }

    /**
     *  Upload Feature Image for development purpose.
     */
    public function GetPathFeatureImage()
    {
        $image = public_path('Test/Images/feature-image.png');
        $file = new UploadedFile($image, 'feature-image.png', 'image/png', null, true);

        return $file;
    }

    // ...
    public function GetImageObject($path)
    {
        return new File(public_path($path));
    }
}
