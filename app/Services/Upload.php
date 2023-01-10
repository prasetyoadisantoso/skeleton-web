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
        Image::make(Storage::path($image_raw))->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadImageLogoToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/Logo';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        // Compress With Intervention
        Image::make(Storage::path($image_raw))->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadImageFaviconToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/Favicon';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        // Compress With Intervention
        Image::make(Storage::path($image_raw))->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadFeatureImageToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/Feature';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        // Compress With Intervention
        Image::make(Storage::path($image_raw))->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadPostImageToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/Content';
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
