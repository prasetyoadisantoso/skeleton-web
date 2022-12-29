<?php

namespace Database\Seeders;

use App\Services\FileManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\Upload;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileManagement = new FileManagement;
        $upload = new Upload;

        $feature_image = $upload->UploadFeatureImageToStorage($fileManagement->GetPathFeatureImage()) ;

        //
        DB::table('posts')->insert([
            [
                'id' => '7b72ae68-4785-4844-868e-7fc0c0517b8c',
                'feature_image' => $feature_image,
                'title' => '{"en":"New Post","id":"Postingan Baru"}',
                'content' => '{"en":"<h5>This is Content</h5>","id":"<h5>Ini Kontent</h5>"}',
                'slug' => 'new-post',
            ]
        ]);
    }
}
