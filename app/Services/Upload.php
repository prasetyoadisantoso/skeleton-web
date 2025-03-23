<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
        try {
            // Compress With Intervention
            $image_manager = new ImageManager(new Driver());
            $image = $image_manager->read(Storage::path($image_raw));
            $image->scale(width: $size);
            $image->save();
        } catch (\Exception $e) {
            // Handle the error (log, throw a custom exception, etc.)
            report($e); // This will send the error to your logs
            throw new \Exception('Error compressing image: '.$e->getMessage());
        }
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
                    ++$count;
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
                    'media_path' => $mediafilepath.'/'.$medianame,
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
                    ++$count;
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
                    'media_path' => $mediafilepath.'/'.$medianame,
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
                    ++$count;
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
                    'media_path' => $mediafilepath.'/'.$medianame,
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
                    ++$count;
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
                    'media_path' => $mediafilepath.'/'.$medianame,
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
                    ++$count;
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
                    'media_path' => $mediafilepath.'/'.$medianame,
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
                    ++$count;
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
                    'media_path' => $mediafilepath.'/'.$medianame,
                ];
                break;

            default:
                throw new \Exception('Media file not found', 1);
                break;
        }
    }

    public function UploadUserImageToMediaLibrary($file)
    {
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $fileType = strtolower($file->getClientOriginalExtension());
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Check if the file type is allowed
        if (!in_array($fileType, $allowedFileTypes)) {
            throw new \Exception('Invalid file type. Allowed types are: '.implode(', ', $allowedFileTypes), 1);
        }

        $mediaFilePath = 'assets/Media/Type/Image';

        // Generate a unique filename
        $originalFilename = $filename.'.'.$fileType;
        $newFilename = $originalFilename;
        $count = 0;

        while (Storage::exists('public/'.$mediaFilePath.'/'.$newFilename)) {
            ++$count;
            $newFilename = $filename.'-'.$count.'.'.$fileType;
        }

        // Upload the file with the new or original filename
        $mediaPath = Storage::putFileAs('public/'.$mediaFilePath, $file, $newFilename);

        $this->CompressionImage($mediaPath, 1000);

        return [
            'media_name' => $newFilename,
            'media_path' => $mediaFilePath.'/'.$newFilename,
        ];
    }

    public function UploadPostContentImageToMediaLibrary($fileData, $filename)
    {
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        // Check the file type based on the filename
        $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if (!in_array($fileType, $allowedFileTypes)) {
            throw new \Exception('Invalid file type. Allowed types are: '.implode(', ', $allowedFileTypes), 1);
        }

        $mediaFilePath = 'assets/Media/Type/Image';
        $newFilename = $filename;
        $count = 0;

        // Check if the file already exists
        while (Storage::exists('public/'.$mediaFilePath.'/'.$newFilename)) {
            ++$count;
            $newFilename = pathinfo($filename, PATHINFO_FILENAME).'-'.$count.'.'.$fileType;
        }

        Storage::disk('public')->put($mediaFilePath.'/'.$newFilename, $fileData);

        return [
            'media_name' => $newFilename,
            'media_path' => $mediaFilePath.'/'.$newFilename,
        ];
    }

    public function UploadPostFeatureImageToMediaLibrary($file)
    {
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $fileType = strtolower($file->getClientOriginalExtension());
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Check if the file type is allowed
        if (!in_array($fileType, $allowedFileTypes)) {
            throw new \Exception('Invalid file type. Allowed types are: '.implode(', ', $allowedFileTypes), 1);
        }

        $mediaFilePath = 'assets/Media/Type/Image';

        // Generate a unique filename
        $originalFilename = $filename.'.'.$fileType;
        $newFilename = $originalFilename;
        $count = 0;

        while (Storage::exists('public/'.$mediaFilePath.'/'.$newFilename)) {
            ++$count;
            $newFilename = $filename.'-'.$count.'.'.$fileType;
        }

        // Upload the file with the new or original filename
        $mediaPath = Storage::putFileAs('public/'.$mediaFilePath, $file, $newFilename);

        $this->CompressionImage($mediaPath, 1000);

        return [
            'media_name' => $newFilename,
            'media_path' => $mediaFilePath.'/'.$newFilename,
        ];
    }
}
