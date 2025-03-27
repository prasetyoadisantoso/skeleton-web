<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opengraph;
use Webpatser\Uuid\Uuid;

class OpengraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh data yang akan di-seed (multi-bahasa)
        $opengraphData = [
            [
                'og_title' => [
                    'en' => 'Example Open Graph Title 1',
                    'id' => 'Contoh Judul Open Graph 1',
                ],
                'og_description' => [
                    'en' => 'Example Open Graph Description 1. This is a short description of the content.',
                    'id' => 'Contoh Deskripsi Open Graph 1. Ini adalah deskripsi singkat tentang konten.',
                ],
                'og_type' => 'article',
                'og_url' => 'https://example.com/article-1',
            ],
            [
                'og_title' => [
                    'en' => 'Example Open Graph Title 2',
                    'id' => 'Contoh Judul Open Graph 2',
                ],
                'og_description' => [
                    'en' => 'Example Open Graph Description 2. This description is slightly longer.',
                    'id' => 'Contoh Deskripsi Open Graph 2. Deskripsi ini sedikit lebih panjang.',
                ],
                'og_type' => 'website',
                'og_url' => 'https://example.com',
            ],
            [
                'og_title' => [
                    'en' => 'Example Open Graph Title 3',
                    'id' => 'Contoh Judul Open Graph 3',
                ],
                'og_description' => [
                    'en' => 'Example Open Graph Description 3.',
                    'id' => 'Contoh Deskripsi Open Graph 3.',
                ],
                'og_type' => 'book',
                'og_url' => null, // Contoh URL null
            ],
        ];

        foreach ($opengraphData as $data) {
            $opengraph = new Opengraph();
            $opengraph->id = Uuid::generate(4)->string;
            $opengraph->og_title = $data['og_title'];
            $opengraph->og_description = $data['og_description'];
            $opengraph->og_type = $data['og_type'];
            $opengraph->og_url = $data['og_url'];
            $opengraph->save();
        }
    }
}
