<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Exception;

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

    public function CompressionImage($image_raw, $size)
    {
        // Compress With Intervention
        $image_manager = new ImageManager(new Driver());
        $image = $image_manager->read(Storage::path($image_raw));
        $image->scale(width: $size);
        $image->save();
    }

    public function UploadFileMediaLibrary($file)
    {

        $filetype = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        switch ($filetype) {

            // JPG
            case 'jpg':
                $mediafilepath = 'assets/Media/Type/jpg';
                $originalFilename = $filename.'.'.$filetype;
                $newFilename = $originalFilename;
                $count = 0;

                // Check if the file already exists
                while (Storage::exists('public/'.$mediafilepath.'/'.$newFilename)) {
                    $count++;
                    $newFilename = $filename.'-'.$count.'.'.$filetype;
                }

                // If the filename needs to be changed, update it
                if ($newFilename !== $originalFilename) {
                    $medianame = $newFilename;
                } else {
                    $medianame = $originalFilename;
                }

                // Upload the file with the new or original filename
                $mediapath = Storage::putFileAs('public/'.$mediafilepath, $file, $medianame);

                return [
                    'media_name' => $medianame,
                    'media_path' => $mediafilepath . '/' . $medianame,
                ];
                break;

                // JPEG
            case 'jpeg':
                $mediafilepath = 'assets/Media/Type/jpeg';
                $originalFilename = $filename.'.'.$filetype;
                $newFilename = $originalFilename;
                $count = 0;

                // Check if the file already exists
                while (Storage::exists('public/'.$mediafilepath.'/'.$newFilename)) {
                    $count++;
                    $newFilename = $filename.'-'.$count.'.'.$filetype;
                }

                // If the filename needs to be changed, update it
                if ($newFilename !== $originalFilename) {
                    $medianame = $newFilename;
                } else {
                    $medianame = $originalFilename;
                }

                // Upload the file with the new or original filename
                $mediapath = Storage::putFileAs('public/'.$mediafilepath, $file, $medianame);


                return [
                    'media_name' => $medianame,
                    'media_path' => $mediafilepath . '/' . $medianame,
                ];
                break;

                // PNG
            case 'png':

                $mediafilepath = 'assets/Media/Type/png';
                $originalFilename = $filename.'.'.$filetype;
                $newFilename = $originalFilename;
                $count = 0;

                // Check if the file already exists
                while (Storage::exists('public/'.$mediafilepath.'/'.$newFilename)) {
                    $count++;
                    $newFilename = $filename.'-'.$count.'.'.$filetype;
                }

                // If the filename needs to be changed, update it
                if ($newFilename !== $originalFilename) {
                    $medianame = $newFilename;
                } else {
                    $medianame = $originalFilename;
                }

                // Upload the file with the new or original filename
                $mediapath = Storage::putFileAs('public/'.$mediafilepath, $file, $medianame);

                return [
                    'media_name' => $medianame,
                    'media_path' => $mediafilepath . '/' . $medianame,
                ];

                break;

                // MP3
            case 'mp3':
                $mediafilepath = 'assets/Media/Type/mp3';
                $originalFilename = $filename.'.'.$filetype;
                $newFilename = $originalFilename;
                $count = 0;

                // Check if the file already exists
                while (Storage::exists('public/'.$mediafilepath.'/'.$newFilename)) {
                    $count++;
                    $newFilename = $filename.'-'.$count.'.'.$filetype;
                }

                // If the filename needs to be changed, update it
                if ($newFilename !== $originalFilename) {
                    $medianame = $newFilename;
                } else {
                    $medianame = $originalFilename;
                }

                // Upload the file with the new or original filename
                $mediapath = Storage::putFileAs('public/'.$mediafilepath, $file, $medianame);

                return [
                    'media_name' => $medianame,
                    'media_path' => $mediafilepath . '/' . $medianame,
                ];
                break;

                // mp4
            case 'mp4':
                $mediafilepath = 'assets/Media/Type/mp4';
                $originalFilename = $filename.'.'.$filetype;
                $newFilename = $originalFilename;
                $count = 0;

                // Check if the file already exists
                while (Storage::exists('public/'.$mediafilepath.'/'.$newFilename)) {
                    $count++;
                    $newFilename = $filename.'-'.$count.'.'.$filetype;
                }

                // If the filename needs to be changed, update it
                if ($newFilename !== $originalFilename) {
                    $medianame = $newFilename;
                } else {
                    $medianame = $originalFilename;
                }

                // Upload the file with the new or original filename
                $mediapath = Storage::putFileAs('public/'.$mediafilepath, $file, $medianame);

                return [
                    'media_name' => $medianame,
                    'media_path' => $mediafilepath . '/' . $medianame,
                ];
                break;

                // PDF
            case 'pdf':

                $mediafilepath = 'assets/Media/Type/pdf';
                $originalFilename = $filename.'.'.$filetype;
                $newFilename = $originalFilename;
                $count = 0;

                // Check if the file already exists
                while (Storage::exists('public/'.$mediafilepath.'/'.$newFilename)) {
                    $count++;
                    $newFilename = $filename.'-'.$count.'.'.$filetype;
                }

                // If the filename needs to be changed, update it
                if ($newFilename !== $originalFilename) {
                    $medianame = $newFilename;
                } else {
                    $medianame = $originalFilename;
                }

                // Upload the file with the new or original filename
                $mediapath = Storage::putFileAs('public/'.$mediafilepath, $file, $medianame);

                return [
                    'media_name' => $medianame,
                    'media_path' => $mediafilepath . '/' . $medianame,
                ];
                break;

            default:

                throw new Exception("Media file not found", 1);

                break;
        }

    }
}
