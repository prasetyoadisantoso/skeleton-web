<?php

namespace Database\Seeders;

use App\Models\Meta;
use Illuminate\Database\Seeder;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Meta untuk Halaman Utama (Index/Home)
        Meta::create([
            'title' => [
                'en' => 'Welcome to My Awesome Blog',
                'id' => 'Selamat Datang di Blog Keren Saya',
            ],
            'description' => [
                'en' => 'Read the latest articles about technology, travel, and food on our blog.',
                'id' => 'Baca artikel terbaru tentang teknologi, perjalanan, dan makanan di blog kami.',
            ],
            'keywords' => [
                'en' => 'blog, technology, travel, food, articles',
                'id' => 'blog, teknologi, perjalanan, makanan, artikel',
            ],
        ]);

        // Meta untuk Halaman Post (dengan Judul "The Ultimate Guide to Laravel 11")
        Meta::create([
            'title' => [
                'en' => 'The Ultimate Guide to Laravel 11',
                'id' => 'Panduan Utama untuk Laravel 11',
            ],
            'description' => [
                'en' => 'Learn everything you need to know about Laravel 11, from installation to advanced features.',
                'id' => 'Pelajari semua yang perlu Anda ketahui tentang Laravel 11, dari instalasi hingga fitur-fitur canggih.',
            ],
            'keywords' => [
                'en' => 'laravel 11, php, framework, tutorial, guide',
                'id' => 'laravel 11, php, framework, tutorial, panduan',
            ],
        ]);
    }
}
