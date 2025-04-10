<?php

namespace Database\Seeders;

use App\Models\Opengraph;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MediaLibrary;
use App\Services\FileManagement;
use App\Services\Upload;

class MediaLibraryOpengraphSeeder extends Seeder
{
    protected $fileManagement;
    protected $upload;

    public function __construct(FileManagement $fileManagement, Upload $upload)
    {
        $this->fileManagement = $fileManagement;
        $this->upload = $upload;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Get all posts
         $ogs = Opengraph::all();

         foreach ($ogs as $og) {
            // Get Opengraph Image from FileManagement
            $ogImageFile = $this->fileManagement->GetPathOpengraphImage();

            // Upload Opengraph Image to Media Library
            $ogImage = $this->upload->UploadOpengraphImageToMediaLibrary($ogImageFile);

            // Simpan ke Media Library
            $media_data = [
                'title' => pathinfo($ogImageFile->getClientOriginalName(), PATHINFO_FILENAME), // Ambil nama file tanpa ekstensi
                'media_files' =>  $ogImage['media_path'],
                'information' => '',
                'description' => '',
            ];
            $media = MediaLibrary::create([
                'title' => $media_data['title'],
                'information' => $media_data['information'],
                'description' => $media_data['description'],
                'media_files' => $media_data['media_files'],
            ]);

            // Update og_image_id di Opengraph
            $og->og_image_id = $media->id;
            $og->save();
        }
    }
}
