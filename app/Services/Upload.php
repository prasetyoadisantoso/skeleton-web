<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        $image = $this->CompressionImage($image_raw, 1000);

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

        $image = $this->CompressionImage($image_raw, 800);

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

        $image = $this->CompressionImage($image_raw, 100);

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadFeatureImageToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/Post/Feature';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        $image = $this->CompressionImage($image_raw, 1000);

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadPostImageToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/Post/Content';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        $image = $this->CompressionImage($image_raw, 1000);

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function UploadOpengraphImageToStorage($filename = null)
    {
        // Processing Image & Upload
        $get_extension = $filename->getClientOriginalExtension();
        $names = Str::random(15).'.'.$get_extension;
        $imagePath = 'assets/Image/SEO/Opengraph';
        $image_raw = Storage::putFileAs('public/'.$imagePath, $filename, $names);

        $image = $this->CompressionImage($image_raw, 800);

        // Return Image Name
        $image = $imagePath.'/'.$names;

        return $image;
    }

    public function CompressionImage($image_raw, $size) {
        // Compress With Intervention
        $image_manager = new ImageManager(new Driver());
        $image = $image_manager->read(Storage::path($image_raw));
        $image->scale(width:$size);
        $image->save();
    }
}
