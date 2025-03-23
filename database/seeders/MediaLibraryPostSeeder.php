<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\MediaLibrary;
use App\Services\FileManagement;
use App\Services\Upload;
use Illuminate\Support\Str;

class MediaLibraryPostSeeder extends Seeder
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
     *
     * @return void
     */
    public function run()
    {
        // Get all posts
        $posts = Post::all();

        foreach ($posts as $post) {
            // Feature Image
            $featureImageFile = $this->fileManagement->GetPathFeatureImage(); // Dapatkan object file
            $feature = $this->upload->UploadPostFeatureImageToMediaLibrary($featureImageFile);

            // Simpan ke Media Library
            $media_data = [
                'title' => $featureImageFile->getClientOriginalName(),
                'media_files' =>  $feature['media_path'],
                'information' => '',
                'description' => '',
            ];
            $media = MediaLibrary::create([
                'title' => $media_data['title'],
                'information' => $media_data['information'],
                'description' => $media_data['description'],
                'media_files' => $media_data['media_files'],
            ]);

            if ($media) {
                $post->mediaLibraries()->attach($media->id);
            }

            // Content Images (simulasi)
            // Kita akan mencari gambar yang namanya mengandung slug postingan
            $contentImages = MediaLibrary::where('media_files', 'like', '%'.$post->slug.'%')->get();

            foreach ($contentImages as $contentImage) {
                $post->mediaLibraries()->attach($contentImage->id);
            }
        }
    }
}
