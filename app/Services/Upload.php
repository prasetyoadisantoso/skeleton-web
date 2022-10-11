<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Upload
{
    public function UploadImageUserToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/User';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        // Compress With Intervention
        Image::make(Storage::path($image_raw))->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }
}
